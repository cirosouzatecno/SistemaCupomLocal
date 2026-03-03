<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupon_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_coupon_id')->constrained('user_coupons')->onDelete('cascade');
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->foreignId('validated_by')->constrained('merchants')->onDelete('cascade');
            $table->timestamp('validated_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_validations');
    }
};
