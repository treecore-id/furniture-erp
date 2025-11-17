<?php

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

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

Route::resource('project', ProjectController::class)->except('edit')->middleware('auth');

Route::resource('wood', WoodController::class)->except('edit')->middleware('auth');
Route::patch('/wood/{wood}/archive', [WoodController::class, 'archive'])->name('wood.archive')->middleware('auth');

require __DIR__.'/settings.php';
