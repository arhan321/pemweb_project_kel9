<?php
use App\Http\Controllers\makan_tempat;
use App\Http\Controllers\GoogleLoginController;

// use App\Http\Controllers\Admin\TablesController;
// use App\Http\Controllers\MidtransController;


Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

//routing frontend untuk makan dittempat
Route::get('/qr', function () {
    return view('layouts.qrcode');
});
//  Route::get('/makan', 'makan_tempat@getmakan')->name('layouts.makan_di_tempat.makan');

Route::get('/makan', [makan_tempat::class, 'index'])->name('makan.index');
Route::post('/makan/addToCart', [makan_tempat::class, 'addToCart'])->name('makan.addToCart');
Route::post('/makan/removeFromCart', [makan_tempat::class, 'removeFromCart'])->name('makan.removeFromCart');
Route::post('/makan/updateCart', [makan_tempat::class, 'updateCart'])->name('makan.updateCart');
Route::get('/makan/get-cart', [makan_tempat::class, 'getCart'])->name('makan.getCart');
Route::post('/makan/saveOrder', [makan_tempat::class, 'saveOrder'])->name('makan.saveOrder');

 Route::get('/reservasi', 'OrderController@index')->name('layouts.reservasi');
 Route::post('/checkout', 'OrderController@checkout')->name('midtrans.checkout');
 Route::post('/midtrans-callback', 'OrderController@callback')->name('midtrans.callback');
 Route::get('/order/{id}', 'OrderController@showOrder')->name('order.show');
 Route::post('/available-tables', 'OrderController@getAvailableTables')->name('available.tables');
//  Route::get('/api/available-tables', [TablesController::class, 'getAvailableTables']);


route::get('/iseng', 'frontend@iseng')->name('frontend.iseng'); 
//post testimonial frontend
Route::post('/testimonial', 'frontend@store')->name('frontend.store');
//routing front end 
Route::get('/', 'frontend@home')->name('frontend.home');
 Route::get('/abouts', 'frontend@abouts')->name('frontend.about');
 Route::get('/menu', 'frontend@menu')->name('frontend.menu');
 Route::get('/signature', 'frontend@signature')->name('frontend.signature');
 Route::get('/testimonial', 'frontend@testimonial')->name('frontend.testimonial');
 Route::get('/galery', 'frontend@galery')->name('frontend.galery');
 Route::get('/chefs', 'frontend@chefs')->name('frontend.chefs');
//  Route::get('/contact', 'frontend@contact')->name('frontend.contact');
// Route::get('/chef', 'frontend@chef')->name('frontend.chef');
// Route::get('/contact', 'frontend@contact')->name('frontend.contact');
// Route::get('/reservasi', 'frontend@reservasi')->name('layouts.reservasi');
Route::get('/error', function () {
    return view('frontend.error');
});


//Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Footer
    Route::delete('footers/destroy', 'FooterController@massDestroy')->name('footers.massDestroy');
    Route::post('footers/media', 'FooterController@storeMedia')->name('footers.storeMedia');
    Route::post('footers/ckmedia', 'FooterController@storeCKEditorImages')->name('footers.storeCKEditorImages');
    Route::resource('footers', 'FooterController');

    // About
    Route::delete('abouts/destroy', 'AboutController@massDestroy')->name('abouts.massDestroy');
    Route::post('abouts/media', 'AboutController@storeMedia')->name('abouts.storeMedia');
    Route::post('abouts/ckmedia', 'AboutController@storeCKEditorImages')->name('abouts.storeCKEditorImages');
    Route::resource('abouts', 'AboutController');

    // Gallery
    Route::delete('galleries/destroy', 'GalleryController@massDestroy')->name('galleries.massDestroy');
    Route::post('galleries/media', 'GalleryController@storeMedia')->name('galleries.storeMedia');
    Route::post('galleries/ckmedia', 'GalleryController@storeCKEditorImages')->name('galleries.storeCKEditorImages');
    Route::resource('galleries', 'GalleryController');

    // Why us
    Route::delete('whys/destroy', 'WhyController@massDestroy')->name('whys.massDestroy');
    Route::post('whys/media', 'WhyController@storeMedia')->name('whys.storeMedia');
    Route::post('whys/ckmedia', 'WhyController@storeCKEditorImages')->name('whys.storeCKEditorImages');
    Route::resource('whys', 'WhyController');
  
    // Data Chef
    Route::delete('datachefs/destroy', 'DatacheffController@massDestroy')->name('datachefs.massDestroy');
    Route::post('datachefs/media', 'DatacheffController@storeMedia')->name('datachefs.storeMedia');
    Route::post('datachefs/ckmedia', 'DatacheffController@storeCKEditorImages')->name('datachefs.storeCKEditorImages');
    Route::resource('datachefs', 'DatacheffController');
     
    // Home
    Route::delete('homes/destroy', 'HomeAdminController@massDestroy')->name('homes.massDestroy');
    Route::post('homes/media', 'HomeAdminController@storeMedia')->name('homes.storeMedia');
    Route::post('homes/ckmedia', 'HomeAdminController@storeCKEditorImages')->name('homes.storeCKEditorImages');
    Route::resource('homes', 'HomeAdminController');
 
    // Tim
    Route::delete('tims/destroy', 'TimController@massDestroy')->name('tims.massDestroy');
    Route::post('tims/media', 'TimController@storeMedia')->name('tims.storeMedia');
    Route::post('tims/ckmedia', 'TimController@storeCKEditorImages')->name('tims.storeCKEditorImages');
    Route::resource('tims', 'TimController');

    // Tables
    Route::delete('tables/destroy', 'TablesController@massDestroy')->name('tables.massDestroy');
    Route::post('tables/media', 'TablesController@storeMedia')->name('tables.storeMedia');
    Route::post('tables/ckmedia', 'TablesController@storeCKEditorImages')->name('tables.storeCKEditorImages');
    Route::resource('tables', 'TablesController');

    // Booking
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');

    // Price
    Route::delete('prices/destroy', 'QuerryorderController@massDestroy')->name('prices.massDestroy');
    Route::resource('prices', 'QuerryorderController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

    // orderditempat
    Route::delete('orderditempats/destroy', 'OrderDitempatController@massDestroy')->name('orderditempats.massDestroy');
    Route::post('orderditempats/media', 'OrderDitempatController@storeMedia')->name('orderditempats.storeMedia');
    Route::post('orderditempats/ckmedia', 'OrderDitempatController@storeCKEditorImages')->name('orderditempats.storeCKEditorImages');
    Route::resource('orderditempats', 'OrderDitempatController');
  
     // signature
     Route::delete('signatures/destroy', 'SignatureController@massDestroy')->name('signatures.massDestroy');
     Route::post('signatures/media', 'SignatureController@storeMedia')->name('signatures.storeMedia');
     Route::post('signatures/ckmedia', 'SignatureController@storeCKEditorImages')->name('signatures.storeCKEditorImages');
     Route::resource('signatures', 'SignatureController');
    
    // history order
    Route::delete('history_order_reservations/destroy', 'HistoryOrderReservationController@massDestroy')->name('history_order_reservations.massDestroy');
    Route::resource('history_order_reservations', 'HistoryOrderReservationController');

    // history order booking manual
    Route::delete('history_booking_manuals/destroy', 'HistoryBookingManualController@massDestroy')->name('history_booking_manuals.massDestroy');
    Route::resource('history_booking_manuals', 'HistoryBookingManualController');

    // testimonials
    Route::delete('testimonials/destroy', 'TestimonialController@massDestroy')->name('testimonials.massDestroy');
    Route::post('testimonials/media', 'TestimonialController@storeMedia')->name('testimonials.storeMedia');
    Route::post('testimonials/ckmedia', 'TestimonialController@storeCKEditorImages')->name('testimonials.storeCKEditorImages');
    Route::resource('testimonials', 'TestimonialController');
     

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
