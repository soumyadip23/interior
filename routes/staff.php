<?php

Route::group(['prefix' => 'staff'], function () {

    Route::get('login', 'Staff\LoginController@showLoginForm')->name('staff.login');
    Route::post('login', 'Staff\LoginController@login')->name('staff.login.post');
	Route::get('logout', 'Staff\LoginController@logout')->name('staff.logout');
	
	//admin password reset routes
    Route::post('/password/email','Staff\ForgotPasswordController@sendResetLinkEmail')->name('staff.password.email');
    Route::get('/password/reset','Staff\ForgotPasswordController@showLinkRequestForm')->name('staff.password.request');
    Route::post('/password/reset','Staff\ResetPasswordController@reset');
    Route::get('/password/reset/{token}','Staff\ResetPasswordController@showResetForm')->name('staff.password.reset');

	Route::get('/register', 'Staff\RegisterController@showRegistrationForm')->name('staff.register');
	Route::post('/register', 'Staff\RegisterController@register')->name('staff.register.post');

    Route::group(['middleware' => ['auth:staff']], function () {

	    Route::get('/dashboard', function () {
	        return view('staff.dashboard.index');
	    })->name('staff.dashboard');

		Route::get('/profile', 'Staff\ProfileController@index')->name('staff.profile');
		Route::post('/profilesave', 'Staff\ProfileController@update')->name('staff.profile.update');
		Route::post('/changepassword', 'Staff\ProfileController@changePassword')->name('staff.profile.changepassword');


		Route::group(['prefix'  =>   'lead'], function() {
			Route::get('/', 'Staff\LeadController@index')->name('staff.lead.index');
			Route::get('/create', 'Staff\LeadController@create')->name('staff.lead.create');
			Route::post('/store', 'Staff\LeadController@store')->name('staff.lead.store');
			Route::get('/{id}/edit', 'Staff\LeadController@edit')->name('staff.lead.edit');
			Route::post('/update', 'Staff\LeadController@update')->name('staff.lead.update');
			Route::get('/{id}/delete', 'Staff\LeadController@delete')->name('staff.lead.delete');
			Route::post('updateStatus', 'Staff\LeadController@updateStatus')->name('staff.lead.updateStatus');
			Route::get('/{id}/details', 'Staff\LeadController@details')->name('staff.lead.details');
			Route::get('/{id}/feedback', 'Staff\LeadController@feedbacks')->name('staff.leads.feedback');
			Route::any('/{id}/feedback/create', 'Staff\LeadController@feedbacksCreate')->name('staff.leads.feedback.create');
			Route::post('feedback/store', 'Staff\LeadController@feedbackStore')->name('staff.feedback.store');
		});

	});

});
?>