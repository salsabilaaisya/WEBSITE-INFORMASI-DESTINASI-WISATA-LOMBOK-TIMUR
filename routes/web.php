<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('articles', 'pages::articles.index')
    ->name('articles.index')
    ->middleware(['auth']);

Route::livewire('categories', 'pages::category.index')
    ->name('categories.index')
    ->middleware(['auth']);

require __DIR__ . '/settings.php';