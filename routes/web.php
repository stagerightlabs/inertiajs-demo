<?php

use Inertia\Inertia;

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.attempt');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.attempt');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Authenticated User Routes
Route::group(['middleware' => 'auth'], function() {
    // Dashboard
    Route::get('home', 'HomeController@index')->name('home');

    // Lists
    Route::post('lists', 'ToDoListController@store')->name('lists.store');
    Route::get('lists/{hashid}', 'ToDoListController@show')->name('lists.show');
    Route::post('lists/{hashid}', 'ToDoListController@update')->name('lists.update');
    Route::delete('lists/{hashid}', 'ToDoListController@destroy')->name('lists.destroy');

    // List Items
    Route::post('lists/{hashid}/items', 'ToDoItemController@store')->name('items.store');
    Route::post('lists/{hashid}/items/{item}/complete', 'ToDoItemCompletionController@store')->name('items.complete');
    Route::delete('lists/{hashid}/items/{item}/complete', 'ToDoItemCompletionController@destroy')->name('items.incomplete');
    Route::post('lists/{hashid}/items/{item}/archive', 'ToDoItemArchiveController@store')->name('items.archive');
    Route::delete('lists/{hashid}/items/{item}/archive', 'ToDoItemArchiveController@destroy')->name('items.unarchive');
    Route::post('lists/{hashid}/items/{item}', 'ToDoItemController@update')->name('items.update');
    Route::delete('lists/{hashid}/items/{item}', 'ToDoItemController@destroy')->name('items.destroy');
});


Route::get('/', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return Inertia::render('Welcome');
});
