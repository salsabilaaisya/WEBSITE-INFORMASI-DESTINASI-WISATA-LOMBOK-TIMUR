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

Route::livewire('/destinations', 'pages::destination.index')
    ->name('destination.index')
    ->middleware(['auth']);

Route::livewire('/destinations/create', 'pages::destination.form')
    ->name('destination.form')
    ->middleware(['auth']);

Route::livewire('/destination/create', 'pages::DestinationIndex::class')
    ->name('destination.index')
    ->middleware(['auth']);

require __DIR__ . '/settings.php';