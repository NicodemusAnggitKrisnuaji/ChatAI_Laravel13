<?php

use App\Http\Controllers\Chatcontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat',[Chatcontroller::class, 'index'])->name('chat');
Route::post('/chat/send',[Chatcontroller::class, 'send'])->name('chat.send');
