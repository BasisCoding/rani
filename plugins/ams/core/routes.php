<?php

// Guest Midleware
Route::group(['middleware' => ['web', 'Ams\Core\Middleware\IsGuest']], function() {
	Route::get('/', function () {
    	return App::make('Cms\Classes\Controller')->run('/');
    });
});

// Registered Midleware
Route::group(['middleware' => ['web', 'Ams\Core\Middleware\IsLogin']], function() {
    // Dashboard
	Route::get('/dashboard', function () {
    	return App::make('Cms\Classes\Controller')->run('/dashboard');
    });

    // Laporan
    Route::group(['prefix' => 'report'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('report');
        });

        Route::get('/detail/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('report/detail/'.$parameter);
        });
    });

    // Label
    Route::get('/label', function () {
        return App::make('Cms\Classes\Controller')->run('/label');
    });

    // Aset
    Route::group(['prefix' => 'asset'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('asset');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('asset/add');
        });

        Route::get('/item/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('asset/item/'.$parameter);
        });

        Route::get('/detail/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('asset/detail/'.$parameter);
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('asset/edit/'.$parameter);
        });
    });

    // Kategori
    Route::group(['prefix' => 'category'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('category');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('category/add');
        });

        Route::get('/item/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('category/item/'.$parameter);
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('category/edit/'.$parameter);
        });
    });

    // Status
    Route::group(['prefix' => 'status'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('status');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('status/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('status/edit/'.$parameter);
        });
    });

    // Pengguna
    Route::group(['prefix' => 'employee'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('employee');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('employee/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('employee/edit/'.$parameter);
        });
    });

    // Department
    Route::group(['prefix' => 'department'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('department');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('department/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('department/edit/'.$parameter);
        });
    });

    // Team
    Route::group(['prefix' => 'team'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('team');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('team/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('team/edit/'.$parameter);
        });
    });

    // Unit
    Route::group(['prefix' => 'unit'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('unit');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('unit/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('unit/edit/'.$parameter);
        });
    });

    // Kantor
    Route::group(['prefix' => 'office'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('office');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('office/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('office/edit/'.$parameter);
        });
    });

    // Gedung
    Route::group(['prefix' => 'building'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('building');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('building/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('building/edit/'.$parameter);
        });
    });

    // Ruangan
    Route::group(['prefix' => 'room'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('room');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('room/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('room/edit/'.$parameter);
        });
    });

    // Mitra
    Route::group(['prefix' => 'partner'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('partner');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('partner/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('partner/edit/'.$parameter);
        });
    });

    // Mitra Kategori
    Route::group(['prefix' => 'partner-category'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('partner-category');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('partner-category/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('partner-category/edit/'.$parameter);
        });
    });

    // Petugas
    Route::group(['prefix' => 'officer', 'middleware' => ['web', 'Ams\Core\Middleware\IsAdmin']], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('officer');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('officer/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('officer/edit/'.$parameter);
        });
    });

    // Pengingat
    Route::group(['prefix' => 'reminder'], function() {
        Route::get('/', function () {
            return App::make('Cms\Classes\Controller')->run('reminder');
        });

        Route::get('/add', function () {
            return App::make('Cms\Classes\Controller')->run('reminder/add');
        });

        Route::get('/edit/{parameter}', function ($parameter) {
            return App::make('Cms\Classes\Controller')->run('reminder/edit/'.$parameter);
        });
    });

    // Pengaturan
    Route::group(['middleware' => ['web', 'Ams\Core\Middleware\IsAdmin']], function() {
        Route::get('/settings', function () {
            return App::make('Cms\Classes\Controller')->run('/settings');
        });
    });

    // Akun
    Route::group(['prefix' => 'account'], function() {
        Route::get('/profile', function () {
            return App::make('Cms\Classes\Controller')->run('account/profile');
        });

        Route::get('/password', function () {
            return App::make('Cms\Classes\Controller')->run('account/password');
        });
    });
});
