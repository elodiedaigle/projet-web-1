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

// Portails encheres
Route::get('/encheres/actives', 'EnchereController@actives');

// Fiche
Route::get('/encheres/fiche', 'EnchereController@fiche');

// Création enchères
Route::get('/encheres/create', 'EnchereController@create');
Route::post('/encheres/create', 'EnchereController@createPost');

// Offre
Route::post('/encheres/offre', 'EnchereController@offrePost');
