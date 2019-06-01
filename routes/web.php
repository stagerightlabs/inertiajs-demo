<?php

use Inertia\Inertia;

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.attempt');
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

Route::get('/', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return Inertia::render('Welcome');
});
