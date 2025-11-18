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
            $table->text('billing_address')->nullable()->after('document_number');
            $table->string('billing_provincia')->nullable()->after('billing_address');
            $table->string('billing_canton')->nullable()->after('billing_provincia');
            $table->string('billing_parroquia')->nullable()->after('billing_canton');
            $table->string('billing_zip')->nullable()->after('billing_parroquia');
            $table->string('billing_country')->default('Ecuador')->after('billing_zip');
            $table->boolean('same_as_billing')->default(true)->after('billing_country');
            $table->string('shipping_name')->nullable()->after('same_as_billing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_address',
                'billing_provincia',
                'billing_canton',
                'billing_parroquia',
                'billing_zip',
                'billing_country',
                'same_as_billing',
                'shipping_name',
            ]);
        });
    }
};
