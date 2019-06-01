<?php

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Route::get('/about', function () {
//     return Inertia::render('About');
// });

// Route::get('/contact', function () {
//     return Inertia::render('Contact');
// });

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
if ($options['register'] ?? true) {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->name('register.attempt');
}
// Password Reset Routes...
if ($options['reset'] ?? true) {
    Route::resetPassword();
}
// Email Verification Routes...
if ($options['verify'] ?? false) {
    Route::emailVerification();
}

Route::get('home', 'HomeController@index')->name('home');

