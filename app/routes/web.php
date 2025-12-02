<?php
use App\Routes\Route;

// Page d'accueil
Route::get('/', 'HomeController@index');

// Page d'inscription
Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@registerPost');