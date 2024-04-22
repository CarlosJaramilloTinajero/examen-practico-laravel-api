<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('companies.index');
});

Route::get('/companies', function () {
    return view('modules.companies.index');
})->name('companies.index');

Route::get('/tasks', function () {
    return view('modules.tasks.index');
})->name('tasks.index');
