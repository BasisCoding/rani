<?php

Route::group([
	'prefix'     => 'api/v1',
	'namespace'  => 'Ams\Api\Controllers',
], function() {

	// Auth
	Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'Auth@login');
		Route::post('logout', 'Auth@logout');
	});

    // Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::post('/', 'Dashboard@index');
    });

	// Users
	Route::group(['prefix' => 'user'], function () {
		Route::get('/', 'Users@get');
	});

    // Report
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', 'Reports@index');
        Route::get('detail', 'Reports@detail');
    });

	// Asset
	Route::group(['prefix' => 'asset'], function () {
        Route::get('/', 'Assets@get');
        Route::get('search', 'Assets@search');
        Route::post('filter', 'Assets@filter');
        Route::post('move', 'Assets@move');
        Route::get('detail', 'Assets@detail');
        Route::post('picture', 'Assets@detailPicture');
        Route::get('code', 'Assets@code');
        Route::post('report', 'Assets@report');

        Route::group(['prefix' => 'item'], function () {
            Route::get('/', 'Assets@item');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'Assets@category');
        });

        Route::group(['prefix' => 'room'], function () {
            Route::get('/', 'Assets@room');
        });

        Route::group(['prefix' => 'status'], function () {
            Route::get('/', 'Assets@status');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'Assets@user');
        });

        Route::group(['prefix' => 'partner'], function () {
            Route::get('/', 'Assets@partner');
        });
	});

    // Reminder
    Route::group(['prefix' => 'reminder'], function () {
        Route::get('/', 'Reminders@index');
        Route::get('/detail', 'Reminders@detail');
    });
});
