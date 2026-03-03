<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('qr_code_token', 100)->unique()->nullable();
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            // Impede que um usuário adicione o mesmo cupom mais de uma vez
            // (o controle de per_user_limit > 1 pode ser feito via contador extra)
            $table->unique(['user_id', 'coupon_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_coupons');
    }
};
