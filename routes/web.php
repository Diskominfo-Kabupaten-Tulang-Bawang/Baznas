<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::get('/', function () {
    return view('auth.login');
});

/**
 * route for admin
 */

//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() {

        //route dashboard
        Route::resource('/dashboard', DashboardController::class, ['as' => 'admin', 'only' => ['index', 'update']]);

        //route resource categories
        Route::resource('/category', CategoryController::class,['as' => 'admin']);

        //route resource campaign
        Route::resource('/campaign', CampaignController::class, ['as' => 'admin']);

        //route donatur
        Route::get('/donatur', [DonaturController::class, 'index'])->name('admin.donatur.index');

        //route donation
        Route::resource('/donation', DonationController::class, ['as' => 'admin']);
        Route::get('admin/donation/filter', [DonationController::class, 'filter'])->name('admin.donation.filter');
        Route::put('admin/donation/update/{id}', [DonationController::class, 'update'])->name('admin.donation.update');
        Route::delete('admin/donation/{id}', [DonationController::class, 'destroy'])->name('admin.donation.destroy');

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

        //route resource slider
        Route::resource('/slider', SliderController::class, ['except' => ['show'], 'as' => 'admin']);



    });
    Route::prefix('files')->group(function () {
        Route::get('baznas/{filename}', [FileController::class, 'baznas'])->name('baznas');
    });





});
