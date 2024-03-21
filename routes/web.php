<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks')->name('home');

Route::redirect('/dashboard', '/tasks')->name('dashboard');

Route::get('tasks', \App\Livewire\Tasks\ShowTasks::class)
    ->middleware(['auth'])
    ->name('tasks');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
