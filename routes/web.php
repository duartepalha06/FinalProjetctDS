<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FuncionarioController;

// Rota raiz
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('products.index');
        } else {
            return redirect()->route('shop.index');
        }
    }
    return redirect()->route('auth.login');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/password/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showReset'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Rotas do Admin (protegidas por middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/estatisticas', [StatisticsController::class, 'index'])->name('estatisticas.index');
    Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/{user}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
    Route::delete('/funcionarios/{user}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
    Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts/{alert}/read', [AlertController::class, 'markAsRead'])->name('alerts.markAsRead');
    Route::post('/alerts/mark-all-read', [AlertController::class, 'markAllAsRead'])->name('alerts.markAllAsRead');
    Route::delete('/alerts/{alert}', [AlertController::class, 'delete'])->name('alerts.delete');
    Route::get('/stock-history', [StockHistoryController::class, 'index'])->name('stock-history.index');
    Route::get('/stock-history/{product}', [StockHistoryController::class, 'productHistory'])->name('stock-history.product');
});

// Rotas da Loja (para utilizadores normais)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::post('/shop/{product}/decrease', [ShopController::class, 'decreaseQuantity'])->name('shop.decrease');
});




