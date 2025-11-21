<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WoodController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');


Route::middleware(['auth', 'can:staff'])->group(function () {
    // Route: Platform
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::resource('project', ProjectController::class)->except('edit');
    Route::patch('/project/{project}/archive', [ProjectController::class, 'archive'])->name('project.archive');

    Route::resource('product', ProductController::class)->except('edit');
    Route::patch('/product/{product}/archive', [ProductController::class, 'archive'])->name('product.archive');
});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('category', CategoryController::class)->except('edit');
    Route::patch('category/{category}/archive', [CategoryController::class, 'archive'])->name('category.archive');

    Route::resource('wood', WoodController::class)->except('edit');
    Route::patch('wood/{wood}/archive', [WoodController::class, 'archive'])->name('wood.archive');
});

require __DIR__.'/settings.php';
