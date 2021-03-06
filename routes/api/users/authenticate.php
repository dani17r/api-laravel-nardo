<?php
Route::prefix('auth')->group(function () {

	Route::get('/', 'AuthController@getUser');
	Route::get('/logout', 'AuthController@logout');
	Route::get('/session', 'AuthController@getSession');

	Route::post('/login', 'AuthController@login');
	Route::post('/refresh', 'AuthController@refresh');

});
