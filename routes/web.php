<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CarBookingController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(HomeController::class)->name('frontend.')->group(function() {
    // home controller related all methods
    Route::get('/','index')->name('index')->middleware('check_page:home');
    Route::get('/redirect/logout','redirectLogout')->name('redirect.logout');
    Route::get('/about','aboutView')->name('about')->middleware('check_page:about');
    Route::get('/contact','contactView')->name('contact')->middleware('check_page:contact');
    Route::get('/find-car','findCarView')->name('find.car')->middleware('check_page:find-car');
    Route::get('/services','servicesView')->name('services')->middleware('check_page:services');
    Route::get('/blog','blogView')->name('blog')->middleware('check_page:blog');
    Route::get('/blog-details/{id}/{slug}','blogDetailsView')->name('blog.details');
    Route::get('/blog-by-category/{id}','blogByCategoryView')->name('blog.by.category');
    Route::get('search/car','searchCar')->name('car.search');
    Route::get('/page/{slug}','usefulPage')->name('useful.link');
    Route::post('get/area/types','getAreaTypes')->name('get.area.types');
    Route::post('contact/message/store', 'contactMessageStore')->name('contact.message.store');
    Route::post('subscribers/store', 'subscribersStore')->name('subscribers.store');
    Route::post('/language/switch', 'languageSwitch')->name('language.switch');


    // car booking
    Route::controller(CarBookingController::class)->name('car.booking.')->group(function(){
        Route::get('/car-booking/{slug}/{car_name}', 'booking')->name('index');
        Route::get('/multi/car-booking', 'multibooking')->name('multibooking');
        Route::post('/get-car-price', 'fetchPrice')->name('fetch_price');
        Route::post('/multi-get-car-price', 'multifetchPrice')->name('multifetchPrice');
        Route::get('bookingcore', 'bookingcore')->name('bookingcore');
        Route::post('store', 'store')->name('store');
        Route::post('multistore', 'multistore')->name('multistore');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('preview/{token}', 'preview')->name('preview');
        Route::get('multipreview/{token}', 'multipreview')->name('multipreview');
        Route::get('confirm/{token}', 'confirm')->name('confirm');
        Route::get('multiconfirm/{token}', 'multiconfirm')->name('multiconfirm');
        Route::get('mail/{token}', 'showMailForm')->name('mail');
        Route::post('mail/verify/{token}', 'mailVerify')->name('mail.verify');
        Route::post('mail/verify/{token}', 'multimailVerify')->name('mail.multiverify');
        Route::get('mail/resend/{token}', 'mailResendToken')->name('mail.resend');

      
        

    });

Route::get('/test-email', function () {
    try {
        Mail::raw('Test email content', function ($message) {
            $message->to('almaqalehmoath@gmail.com')
                    ->subject('Test Email');
        });
        return 'Email sent successfully';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
});


