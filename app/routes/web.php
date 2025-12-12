<?php
use App\Routes\Route;

/* 
=======
ACCUEIL
=======
*/

// HomeController
Route::get('/', 'HomeController@index');

/* 
================
AUTHENTIFICATION
================
*/

// Register
Route::get('/register', 'AuthController@register');
Route::post('/register', 'AuthController@registerPost');

// Login
Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@loginPost');

// Logout
Route::get('/logout', 'AuthController@logout');

/* 
========
ENCHÈRES
========
*/

// Portail enchères actives
Route::get('/encheres/actives', 'EnchereController@actives');

// Portail enchères archivées
Route::get('/encheres/archivees', 'EnchereController@archivees');

// Fiche détail
Route::get('/encheres/fiche', 'EnchereController@fiche');

// Création enchères
Route::get('/encheres/create', 'EnchereController@create');
Route::post('/encheres/create', 'EnchereController@createPost');

// Offre
Route::post('/encheres/offre', 'EnchereController@offrePost');
