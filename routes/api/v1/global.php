<?php

use App\Http\Controllers\Api\V1\GlobalController;
use App\Http\Controllers\Api\V1\Settings\BasicSettingsController;
use Illuminate\Support\Facades\Route;

    Route::controller(BasicSettingsController::class)->group(function(){
        Route::get('basic-settings','basicSettings');
        Route::get("languages","getLanguages");
        Route::get('splash-screen','splashScreen');
        Route::get('onboard-screen','onboardScreen');
    });

    Route::controller(GlobalController::class)->group(function(){
        Route::get('car/area','carArea');
        Route::get('car/type','carType');
        Route::get('cars','viewCar');
        Route::post('car/booking','store');
        Route::post('area/types','getAreaTypes');
        Route::post('search/car','searchCar');
        Route::get('confirm','confirm');
        Route::post('booking/verify','mailVerify');
        Route::get('mail/resend', 'mailResendToken');
    });
?>
