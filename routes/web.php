<?php

use App\Http\Controllers\ChatroomController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function (){
    Route::get('rooms', [ChatroomController::class, 'index'])->name('room.view');
    Route::post('rooms', [ChatroomController::class, 'createRoom'])->name('room.store');
    Route::get('rooms/{room:slug}', [ChatroomController::class, 'messageView'])->name('room.message.view');
});

require __DIR__.'/auth.php';
