# Testing Guide for User Creation & Email Fixes

## Issues Fixed

### 1. User Account Not Being Created
**Problem:** When customers placed orders (both transfer and PayPhone), user accounts were not being created in the database.

**Root Cause:** User creation was happening inside the database transaction (`DB::beginTransaction()`). If anything failed after user creation, the entire transaction would rollback, removing the user.

**Fix Applied:** Moved user creation to BEFORE the transaction starts.
- Location: `app/Http/Controllers/CheckoutController.php` lines 111-119
- User creation now happens before line 121 (`DB::beginTransaction()`)
- This ensures users persist in the database even if order creation fails

### 2. PayPhone Missing Order Confirmation Email
**Problem:** When customers paid via PayPhone and payment was approved, no order confirmation email was sent.

**Root Cause:** PayPhone webhook handler had a TODO comment but no email implementation.

**Fix Applied:** Added OrderConfirmedEmail sending when PayPhone payment is approved.
- Location: `app/Http/Controllers/PayPhoneWebhookController.php` lines 62-76
- Sends email when `isPaymentApproved()` returns true
- Updates `email_order_confirmed` flag on order
- Logs email sending success/failure

## Testing Checklist

### Test 1: Bank Transfer Order
1. **Navigate to checkout** with items in cart
2. **Fill in customer details:**
   - Use a NEW email address (one that doesn't exist in users table)
   - Complete all required fields
3. **Select payment method:** Transfer
4. **Place order**
5. **Verify:**
   - ✅ User account created in `users` table
   - ✅ Order created in `orders` table
   - ✅ Welcome email sent to customer with login credentials
   - ✅ Order pending transfer email sent
   - ✅ Success page shows PASO 1 (bank details) and PASO 2 (receipt submission)

### Test 2: PayPhone Order
1. **Navigate to checkout** with items in cart
2. **Fill in customer details:**
   - Use a NEW email address (different from Test 1)
   - Complete all required fields
3. **Select payment method:** PayPhone
4. **Complete PayPhone payment** in test mode
5. **Verify:**
   - ✅ User account created in `users` table
   - ✅ Order created in `orders` table
   - ✅ Welcome email sent to customer with login credentials
   - ✅ PayPhone webhook receives notification
   - ✅ **Order confirmation email sent** when payment approved
   - ✅ Order status updated to "processing"
   - ✅ Payment status updated to "completed"

### Test 3: Existing User
1. **Navigate to checkout** with items in cart
2. **Fill in customer details:**
   - Use an email that ALREADY exists in users table
   - Complete all required fields
3. **Place order** (either payment method)
4. **Verify:**
   - ✅ No duplicate user created
   - ✅ Order linked to existing user account
   - ✅ No welcome email sent (user already exists)
   - ✅ Only order-related emails sent

### Test 4: Consent Options
1. **Navigate to checkout** with items in cart
2. **Fill in customer details** with new email
3. **Check consent boxes:**
   - ✅ Newsletter subscription
   - ✅ Social media consent
4. **Place order**
5. **Verify in database:**
   - ✅ User created with `newsletter_subscription = 1`
   - ✅ User created with `social_media_consent = 1`
6. **Check admin panel:**
   - Navigate to `/admin/users`
   - Edit the new user
   - ✅ Consent checkboxes should be checked

## Checking Email Sending

### View Email Logs
```bash
# Real-time log monitoring
php artisan pail

# Or view log file directly
tail -f storage/logs/laravel.log | grep -i "email\|mail"
```

### Search for Specific Log Entries
```bash
# Welcome email logs
grep "Welcome email sent" storage/logs/laravel.log

# Order confirmation email logs
grep "Order confirmation email sent" storage/logs/laravel.log

# Order pending transfer email logs
grep "Order pending transfer email sent" storage/logs/laravel.log

# Email failures
grep "Failed to send" storage/logs/laravel.log
```

### Check Database
```bash
php artisan tinker
```

Then in tinker:
```php
// Check if users are being created
\App\Models\User::latest()->take(5)->get(['id', 'name', 'email', 'created_at']);

// Check latest orders
\App\Models\Order::latest()->take(5)->get(['order_number', 'customer_email', 'payment_status', 'status']);

// Check a specific user's consent options
$user = \App\Models\User::where('email', 'test@example.com')->first();
$user->only(['newsletter_subscription', 'social_media_consent']);

// Check if order confirmation email was sent
\App\Models\Order::where('order_number', 'IM-xxx')->first()->email_order_confirmed;
```

## Common Issues to Watch For

### Email Not Sending
- Check `.env` for correct `MAIL_MAILER` settings
- Verify `MAIL_FROM_ADDRESS` is set
- Check `storage/logs/laravel.log` for email errors
- Ensure queue worker is running if using queue

### User Not Created
- Check logs for "Failed to create user account"
- Verify email validation rules
- Check for database constraint violations

### PayPhone Webhook Not Triggering
- Verify webhook URL is configured in PayPhone dashboard
- Check PayPhone logs for webhook delivery status
- Ensure webhook route is not behind auth middleware
- Check logs: `grep "PayPhone webhook" storage/logs/laravel.log`

## Email Templates Being Sent

### 1. WelcomeEmail
- **Sent to:** New customers (first-time buyers)
- **Contains:** Login credentials (email + random password)
- **Sent when:** New user account is created during checkout
- **Template:** `resources/views/emails/welcome.blade.php`

### 2. OrderPendingTransferEmail
- **Sent to:** Customers who chose bank transfer
- **Contains:** Bank account details, order number, instructions
- **Sent when:** Transfer order is created
- **Template:** `resources/views/emails/order-pending-transfer.blade.php`

### 3. OrderConfirmedEmail
- **Sent to:** Customers whose PayPhone payment was approved
- **Contains:** Order confirmation, order details
- **Sent when:** PayPhone webhook confirms payment
- **Template:** `resources/views/emails/order-confirmed.blade.php`

## Files Modified

1. **app/Http/Controllers/CheckoutController.php**
   - Lines 111-119: User creation moved outside transaction

2. **app/Http/Controllers/PayPhoneWebhookController.php**
   - Line 5: Added `OrderConfirmedEmail` import
   - Line 10: Added `Mail` facade import
   - Lines 62-76: Added email sending when payment approved

## Next Steps After Testing

If issues persist:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify `.env` configuration
3. Test email sending manually via tinker
4. Check PayPhone webhook logs
5. Verify database has all required fields
