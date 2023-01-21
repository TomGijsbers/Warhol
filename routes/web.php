<?php

use App\Http\Controllers\DalleController;
use App\Http\Livewire\Admin\Genres;
use App\Http\Livewire\Admin\Paintings;
use App\Http\Livewire\Admin\Users;
use App\Http\Livewire\Admin\UsersBasic;
use App\Http\Livewire\Shop;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaintingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');
Route::get('shop', Shop::class)->name('shop');
Route::view('contact', 'contact')->name('contact');

Route::view('dall-e', 'dalle')->name('dall-e');
Route::post('/dall-e-api', [DalleController::class, 'search']);




Route::middleware(['auth', 'active', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/paintings');
    Route::get('genres', Genres::class)->name('genres');
    Route::get('paintings_old', [PaintingsController::class, 'index'])->name('paintings.old');
    Route::get('paintings', Paintings::class)->name('paintings');
    Route::get('users/basic', UsersBasic::class)->name('users.basic');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'active',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
