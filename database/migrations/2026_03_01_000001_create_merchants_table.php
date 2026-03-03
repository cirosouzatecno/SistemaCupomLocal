<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // nome fantasia
            $table->string('owner_name');
            $table->string('cnpj_cpf', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 20)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('logo_path')->nullable();
            $table->enum('status', ['pending', 'active', 'blocked'])->default('pending');
            $table->enum('plan', ['basic', 'premium'])->default('basic');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
