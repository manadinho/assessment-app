<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OptionController;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return redirect()->route('products.index');
})->name('dashboard');

// Products Routes //
Route::group(['prefix' => 'products', 'as' => 'products.'], function() {
    Route::get('/index', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::get('/delete/{product}', [ProductController::class, 'delete'])->name('delete');
});

// Options Routes //
Route::group(['prefix' => 'options', 'as' => 'options.'], function() {
    Route::get('/index', [OptionController::class, 'index'])->name('index');
    Route::view('/create', 'options.create')->name('create');
    Route::post('/store', [OptionController::class, 'store'])->name('store');
    Route::get('/edit/{option}', [OptionController::class, 'edit'])->name('edit');
    Route::get('/delete/{option}', [OptionController::class, 'delete'])->name('delete');
});
