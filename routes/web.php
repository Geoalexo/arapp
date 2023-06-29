<?php

use App\Http\Controllers\SightController;
use App\Models\Sight;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('home', [
    'sights' => Sight::where('is_visible', true)
        ->orderBy('created_at')
        ->get(),
]))->name('home');

Route::get('sights/{sight:slug}', [SightController::class, 'show'])->name('sights.show');