<?php

Route::group(['prefix' => 'vendor'], function () {

    Route::get('login', 'Vendor\LoginController@showLoginForm')->name('vendor.login');
    Route::post('login', 'Vendor\LoginController@login')->name('vendor.login.post');
	Route::get('logout', 'Vendor\LoginController@logout')->name('vendor.logout');
	
	//admin password reset routes
    Route::post('/password/email','Vendor\ForgotPasswordController@sendResetLinkEmail')->name('vendor.password.email');
    Route::get('/password/reset','Vendor\ForgotPasswordController@showLinkRequestForm')->name('vendor.password.request');
    Route::post('/password/reset','Vendor\ResetPasswordController@reset');
    Route::get('/password/reset/{token}','Vendor\ResetPasswordController@showResetForm')->name('vendor.password.reset');

	Route::get('/register', 'Vendor\RegisterController@showRegistrationForm')->name('vendor.register');
	Route::post('/register', 'Vendor\RegisterController@register')->name('vendor.register.post');

    Route::group(['middleware' => ['auth:vendor']], function () {

	    Route::get('/dashboard', function () {
	        return view('vendor.dashboard.index');
	    })->name('vendor.dashboard');

		
		
		
		Route::get('/profile', 'Vendor\ProfileController@index')->name('vendor.profile');


		// Route::get('/profile', function () {
	    //     echo "kkk"; die;
	    // })->name('vendor.profile');



		Route::post('/profilesave', 'Vendor\ProfileController@update')->name('vendor.profile.update');
		Route::post('/changepassword', 'Vendor\ProfileController@changePassword')->name('vendor.profile.changepassword');

	});

});
?>