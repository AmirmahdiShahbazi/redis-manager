<?php
use Illuminate\Support\Facades\Route;
use Shahbazi\RedisManager\Controllers\RedisPageController;

Route::get('/redis', [RedisPageController::class, 'managePage']);
