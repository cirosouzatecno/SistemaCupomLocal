<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\MerchantAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserCouponController;
use App\Http\Controllers\Merchant\MerchantDashboardController;
use App\Http\Controllers\Merchant\MerchantCouponController;
use App\Http\Controllers\Merchant\MerchantProfileController;
use App\Http\Controllers\Merchant\CouponValidationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMerchantController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\PublicController;

// ═══════════════════════════════════════════════════════════════════════════════
// ÁREA PÚBLICA
// ═══════════════════════════════════════════════════════════════════════════════

Route::get('/',               [PublicController::class, 'home'])->name('home');
Route::get('/cupons',         [PublicController::class, 'index'])->name('coupons.index');
Route::get('/cupons/{coupon}',[PublicController::class, 'show'])->name('coupons.show');

// ═══════════════════════════════════════════════════════════════════════════════
// AUTENTICAÇÃO — USUÁRIO FINAL
// ═══════════════════════════════════════════════════════════════════════════════

Route::prefix('usuario')->name('user.')->group(function () {

    // Rotas para visitantes (não logados)
    Route::middleware('guest:web')->group(function () {
        Route::get('/registro',  [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/registro', [UserAuthController::class, 'register'])->name('register.post');
        Route::get('/login',     [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',    [UserAuthController::class, 'login'])->name('login.post');
    });

    // Rotas protegidas (usuário logado)
    Route::middleware('auth:web')->group(function () {
        Route::post('/logout',    [UserAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard',  [UserDashboardController::class, 'index'])->name('dashboard');

        // ── Meus Cupons (Etapa 4) ─────────────────────────────────────────
        Route::get('/meus-cupons',                    [UserCouponController::class, 'index'])->name('meus-cupons');
        Route::post('/cupons/{coupon}/adicionar',      [UserCouponController::class, 'store'])->name('coupons.store');
        Route::get('/meus-cupons/{userCoupon}',        [UserCouponController::class, 'show'])->name('meus-cupons.show');
    });
});

// ═══════════════════════════════════════════════════════════════════════════════
// AUTENTICAÇÃO — LOJISTA
// ═══════════════════════════════════════════════════════════════════════════════

Route::prefix('lojista')->name('merchant.')->group(function () {

    // Rotas para visitantes
    Route::middleware('guest:merchant')->group(function () {
        Route::get('/registro',  [MerchantAuthController::class, 'showRegister'])->name('register');
        Route::post('/registro', [MerchantAuthController::class, 'register'])->name('register.post');
        Route::get('/login',     [MerchantAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',    [MerchantAuthController::class, 'login'])->name('login.post');
    });

    // Rotas protegidas
    Route::middleware('auth:merchant')->group(function () {
        Route::post('/logout',   [MerchantAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [MerchantDashboardController::class, 'index'])->name('dashboard');

        // ── CRUD de cupons (Etapa 5) ─────────────────────────────────
        Route::get('/cupons',                         [MerchantCouponController::class, 'index'])->name('coupons.index');
        Route::get('/cupons/criar',                   [MerchantCouponController::class, 'create'])->name('coupons.create');
        Route::post('/cupons',                        [MerchantCouponController::class, 'store'])->name('coupons.store');
        Route::post('/cupons/gerar-imagem-ia',        [MerchantCouponController::class, 'generateAiImage'])->name('coupons.ai-image');
        Route::get('/cupons/{coupon}/editar',         [MerchantCouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/cupons/{coupon}',                [MerchantCouponController::class, 'update'])->name('coupons.update');
        Route::delete('/cupons/{coupon}',             [MerchantCouponController::class, 'destroy'])->name('coupons.destroy');

        // ── Perfil (Etapa 5) ──────────────────────────────────────────
        Route::get('/perfil',  [MerchantProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/perfil',  [MerchantProfileController::class, 'update'])->name('profile.update');

        // ── Validar cupom (Etapa 6) ──────────────────────────────────
        Route::get('/validar',            [CouponValidationController::class, 'showForm'])->name('validate.form');
        Route::post('/validar',           [CouponValidationController::class, 'lookup'])->name('validate.lookup');
        Route::post('/validar/confirmar', [CouponValidationController::class, 'confirm'])->name('validate.confirm');
    });
});

// ═══════════════════════════════════════════════════════════════════════════════
// AUTENTICAÇÃO — ADMIN
// ═══════════════════════════════════════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->group(function () {

    // Rotas para visitantes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Rotas protegidas
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout',   [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ── Lojistas (Etapa 7) ───────────────────────────────────
        Route::get('/lojistas',                          [AdminMerchantController::class, 'index'])->name('merchants.index');
        Route::get('/lojistas/{merchant}',               [AdminMerchantController::class, 'show'])->name('merchants.show');
        Route::post('/lojistas/{merchant}/aprovar',      [AdminMerchantController::class, 'approve'])->name('merchants.approve');
        Route::post('/lojistas/{merchant}/bloquear',     [AdminMerchantController::class, 'block'])->name('merchants.block');
        Route::post('/lojistas/{merchant}/reativar',     [AdminMerchantController::class, 'reactivate'])->name('merchants.reactivate');

        // ── Estatísticas (Etapa 7) ───────────────────────────────────
        Route::get('/estatisticas', [AdminStatsController::class, 'index'])->name('stats');
    });
});
