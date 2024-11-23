<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth; 

use App\Exports\TasksExport;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/login');

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {

    Route::redirect('/home', '/tasks');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{id}/complete', [TaskController::class, 'markComplete'])->name('tasks.complete');
    Route::post('/tasks/{id}/paid', [TaskController::class, 'markPaid'])->name('tasks.paid');

    Route::get('/tasks/export', function () {
        return Excel::download(new TasksExport, 'tasks.csv');
    })->name('tasks.export');

    Route::get('/tasks/pay/{id}', [TaskController::class, 'showPayment'])->name('tasks.pay');
    Route::post('/tasks/pay/{id}', [TaskController::class, 'processPayment'])->name('tasks.processPayment');
});
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


