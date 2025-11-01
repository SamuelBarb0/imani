<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Comprobante de pago (para transferencias)
            $table->string('payment_proof')->nullable()->after('payphone_transaction_id');

            // Tracking information
            $table->string('tracking_number')->nullable()->after('payment_proof');
            $table->string('courier')->nullable()->after('tracking_number');
            $table->timestamp('shipped_at')->nullable()->after('courier');

            // Email notifications tracking
            $table->boolean('email_order_confirmed')->default(false)->after('shipped_at');
            $table->boolean('email_tracking_sent')->default(false)->after('email_order_confirmed');

            // Additional status info
            $table->text('admin_notes')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'tracking_number',
                'courier',
                'shipped_at',
                'email_order_confirmed',
                'email_tracking_sent',
                'admin_notes',
            ]);
        });
    }
};
