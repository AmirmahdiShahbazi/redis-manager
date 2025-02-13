<?php
use Illuminate\Support\Facades\Route;
use Shahbazi\RedisManager\Controllers\RedisPageController;

Route::get('/redis', [RedisPageController::class, 'managePage'])->name('redis');
Route::get('/redis/delete', [RedisPageController::class, 'delete'])->name('redis.delete');