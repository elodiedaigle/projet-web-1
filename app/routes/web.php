<?php
use App\Routes\Route;

// HomeController
Route::get('/', 'HomeController@index');

// Register
Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@registerPost');

// Login
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@loginPost');

// Logout
Route::get('/logout', 'AuthController@logout');

// Enchere
Route::get('/encheres/actives', 'EnchereController@actives');
