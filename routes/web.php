<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/tests2', function () {
	// $cateries = App\Models\Category::findOrFail(1);
	// return $cateries->types;

	// $types = App\Models\Type::findOrFail(1);
	// return $types->categories;
	return 'nada';
});

Route::namespace('Main\Admin')->group(function () {
	Route::get('/tests', 'CategoryController@getAll');
});

Route::namespace('Main\Anom')->group(function () {
	Route::get('public/{dir}/{filename}', 'CarouselController@viewImage');
});
