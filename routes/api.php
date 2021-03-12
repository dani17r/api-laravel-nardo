<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/')->group(function () {

	Route::namespace('Main\Admin')->group(function () {

		Route::middleware(['api'])->group(function () {

			include 'api/admin/authenticate.php';

			include 'api/admin/carousel.php';

			include 'api/admin/categories.php';
			
			include 'api/admin/types.php';

		});

	});

});

Route::prefix('user/')->group(function () {

	Route::namespace('Main\Users')->group(function () {

		Route::middleware(['api'])->group(function () {

			include 'api/users/authenticate.php';

		});

	});

});

Route::namespace('Main\Anom')->group(function () {

	Route::get('carousel/all', 'CarouselController@getAll');

});
