<?php

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
	Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
	
	//admin password reset routes
    Route::post('/password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset','Admin\ResetPasswordController@reset');
    Route::get('/password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

	Route::get('/register', 'Admin\RegisterController@showRegistrationForm')->name('admin.register')->middleware('hasInvitation');
	Route::post('/register', 'Admin\RegisterController@register')->name('admin.register.post');

    Route::group(['middleware' => ['auth:admin']], function () {

	    Route::get('/', function () {
	        return view('admin.dashboard.index');
	    })->name('admin.dashboard');

		Route::get('/invite_list', 'Admin\InvitationController@index')->name('admin.invite');
	    Route::get('/invitation', 'Admin\InvitationController@create')->name('admin.invite.create');
		Route::post('/invitation', 'Admin\InvitationController@store')->name('admin.invitation.store');
		Route::get('/adminuser', 'Admin\AdminUserController@index')->name('admin.adminuser');
		Route::post('/adminuser', 'Admin\AdminUserController@updateAdminUser')->name('admin.adminuser.update');
	    Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
		Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');
		
		Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
		Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');
		Route::post('/changepassword', 'Admin\ProfileController@changePassword')->name('admin.profile.changepassword');

		Route::group(['prefix'  =>   'banner'], function() {
			Route::get('/', 'Admin\BannerController@index')->name('admin.banner.index');
			Route::get('/create', 'Admin\BannerController@create')->name('admin.banner.create');
			Route::post('/store', 'Admin\BannerController@store')->name('admin.banner.store');
			Route::get('/{id}/edit', 'Admin\BannerController@edit')->name('admin.banner.edit');
			Route::post('/update', 'Admin\BannerController@update')->name('admin.banner.update');
			Route::get('/{id}/delete', 'Admin\BannerController@delete')->name('admin.banner.delete');
			Route::post('updateStatus', 'Admin\BannerController@updateStatus')->name('admin.banner.updateStatus');
		});

		
		Route::group(['prefix'  =>   'users'], function() {
			Route::get('/', 'Admin\UserManagementController@index')->name('admin.users.index');
			Route::post('/', 'Admin\UserManagementController@updateUser')->name('admin.users.post');
			Route::get('/create', 'Admin\UserManagementController@create')->name('admin.users.create');
			Route::post('/store', 'Admin\UserManagementController@store')->name('admin.users.store');
			Route::get('/{id}/delete', 'Admin\UserManagementController@delete')->name('admin.users.delete');
			Route::get('/{id}/edit', 'Admin\UserManagementController@edit')->name('admin.users.edit');
			Route::post('/update', 'Admin\UserManagementController@update')->name('admin.users.update');
			Route::post('updateStatus', 'Admin\UserManagementController@updateStatus')->name('admin.users.updateStatus');
			Route::get('/{id}/details', 'Admin\UserManagementController@details')->name('admin.users.details');
			Route::get('/{id}/orders', 'Admin\UserManagementController@orders')->name('admin.users.orders');
			Route::get('/{id}/reviews', 'Admin\UserManagementController@reviews')->name('admin.users.reviews');
			Route::get('/{id}/createorder', 'Admin\UserManagementController@createOrder')->name('admin.users.createOrder');
			Route::post('addUserCart', 'Admin\UserManagementController@addUserCart')->name('admin.users.addUserCart');
			Route::get('/{id}/usercart/{restaurantId}', 'Admin\UserManagementController@userCart')->name('admin.users.userCart');
			Route::post('updateUserCart', 'Admin\UserManagementController@updateUserCart')->name('admin.users.updateUserCart');
			Route::post('createUserOrder', 'Admin\UserManagementController@createUserOrder')->name('admin.users.createUserOrder');
			Route::get('file-import-export', 'Admin\UserManagementController@fileImportExport');
            Route::post('file-import', 'Admin\UserManagementController@fileImport')->name('file-import');
            Route::get('file-export', 'Admin\UserManagementController@fileExport')->name('file-export');
		});
		
		// Route::group(['prefix'  =>   'business'], function() {
		// 	Route::get('/', 'Admin\BusinessController@index')->name('admin.business.index');
		// 	Route::get('/create', 'Admin\BusinessController@create')->name('admin.business.create');
		// 	Route::post('/store', 'Admin\BusinessController@store')->name('admin.business.store');
		// 	Route::get('/{id}/edit', 'Admin\BusinessController@edit')->name('admin.business.edit');
		// 	Route::post('/update', 'Admin\BusinessController@update')->name('admin.business.update');
		// 	Route::get('/{id}/delete', 'Admin\BusinessController@delete')->name('admin.business.delete');
		// 	Route::post('updateStatus', 'Admin\BusinessController@updateStatus')->name('admin.business.updateStatus');
		// 	Route::get('/{id}/details', 'Admin\BusinessController@details')->name('admin.business.details');
		// });

		Route::group(['prefix'  =>   'category'], function() {
			Route::get('/', 'Admin\CategoryController@index')->name('admin.category.index');
			Route::get('/create', 'Admin\CategoryController@create')->name('admin.category.create');
			Route::post('/store', 'Admin\CategoryController@store')->name('admin.category.store');
			Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('admin.category.edit');
			Route::post('/update', 'Admin\CategoryController@update')->name('admin.category.update');
			Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('admin.category.delete');
			Route::post('updateStatus', 'Admin\CategoryController@updateStatus')->name('admin.category.updateStatus');
			Route::get('/{id}/details', 'Admin\CategoryController@details')->name('admin.category.details');
		});

		Route::group(['prefix'  =>   'blog'], function() {
			Route::get('/', 'Admin\BlogController@index')->name('admin.blog.index');
			Route::get('/create', 'Admin\BlogController@create')->name('admin.blog.create');
			Route::post('/store', 'Admin\BlogController@store')->name('admin.blog.store');
			Route::get('/{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
			Route::post('/update', 'Admin\BlogController@update')->name('admin.blog.update');
			Route::get('/{id}/delete', 'Admin\BlogController@delete')->name('admin.blog.delete');
			Route::post('updateStatus', 'Admin\BlogController@updateStatus')->name('admin.blog.updateStatus');
			Route::get('/{id}/details', 'Admin\BlogController@details')->name('admin.blog.details');
		});

		Route::group(['prefix'  =>   'notification'], function() {
			Route::get('/', 'Admin\NotificationController@index')->name('admin.notification.index');
			Route::get('/create', 'Admin\NotificationController@create')->name('admin.notification.create');
			Route::post('/store', 'Admin\NotificationController@store')->name('admin.notification.store');
			Route::get('/{id}/delete', 'Admin\NotificationController@delete')->name('admin.notification.delete');
			Route::get('/sos', 'Admin\NotificationController@sos')->name('admin.notification.sos');
		});

		Route::group(['prefix'  =>   'cousine'], function() {
			Route::get('/', 'Admin\CousineController@index')->name('admin.cousine.index');
			Route::get('/create', 'Admin\CousineController@create')->name('admin.cousine.create');
			Route::post('/store', 'Admin\CousineController@store')->name('admin.cousine.store');
			Route::get('/{id}/edit', 'Admin\CousineController@edit')->name('admin.cousine.edit');
			Route::post('/update', 'Admin\CousineController@update')->name('admin.cousine.update');
			Route::get('/{id}/delete', 'Admin\CousineController@delete')->name('admin.cousine.delete');
			Route::post('updateStatus', 'Admin\CousineController@updateStatus')->name('admin.cousine.updateStatus');
			Route::get('/{id}/details', 'Admin\CousineController@details')->name('admin.cousine.details');
		});

		Route::group(['prefix'  =>   'cousine'], function() {
			Route::get('/', 'Admin\CousineController@index')->name('admin.cousine.index');
			Route::get('/create', 'Admin\CousineController@create')->name('admin.cousine.create');
			Route::post('/store', 'Admin\CousineController@store')->name('admin.cousine.store');
			Route::get('/{id}/edit', 'Admin\CousineController@edit')->name('admin.cousine.edit');
			Route::post('/update', 'Admin\CousineController@update')->name('admin.cousine.update');
			Route::get('/{id}/delete', 'Admin\CousineController@delete')->name('admin.cousine.delete');
			Route::post('updateStatus', 'Admin\CousineController@updateStatus')->name('admin.cousine.updateStatus');
			Route::get('/{id}/details', 'Admin\CousineController@details')->name('admin.cousine.details');
		});

		Route::group(['prefix'  =>   'location'], function() {
			Route::get('/', 'Admin\LocationController@index')->name('admin.location.index');
			Route::get('/create', 'Admin\LocationController@create')->name('admin.location.create');
			Route::post('/store', 'Admin\LocationController@store')->name('admin.location.store');
			Route::get('/{id}/edit', 'Admin\LocationController@edit')->name('admin.location.edit');
			Route::post('/update', 'Admin\LocationController@update')->name('admin.location.update');
			Route::get('/{id}/delete', 'Admin\LocationController@delete')->name('admin.location.delete');
			Route::post('updateStatus', 'Admin\LocationController@updateStatus')->name('admin.location.updateStatus');
			Route::get('/{id}/details', 'Admin\LocationController@details')->name('admin.location.details');
		});

		Route::group(['prefix'  =>   'commission'], function() {
			Route::get('/', 'Admin\CommissionController@index')->name('admin.commission.index');
			Route::get('/create', 'Admin\CommissionController@create')->name('admin.commission.create');
			Route::post('/store', 'Admin\CommissionController@store')->name('admin.commission.store');
			Route::get('/{id}/edit', 'Admin\CommissionController@edit')->name('admin.commission.edit');
			Route::post('/update', 'Admin\CommissionController@update')->name('admin.commission.update');
			Route::get('/{id}/delete', 'Admin\CommissionController@delete')->name('admin.commission.delete');
			Route::post('updateStatus', 'Admin\CommissionController@updateStatus')->name('admin.commission.updateStatus');
			Route::get('/{id}/details', 'Admin\CommissionController@details')->name('admin.commission.details');
		});

		Route::group(['prefix'  =>   'incentive'], function() {
			Route::get('/', 'Admin\IncentiveController@index')->name('admin.incentive.index');
			Route::get('/create', 'Admin\IncentiveController@create')->name('admin.incentive.create');
			Route::post('/store', 'Admin\IncentiveController@store')->name('admin.incentive.store');
			Route::get('/{id}/edit', 'Admin\IncentiveController@edit')->name('admin.incentive.edit');
			Route::post('/update', 'Admin\IncentiveController@update')->name('admin.incentive.update');
			Route::get('/{id}/delete', 'Admin\IncentiveController@delete')->name('admin.incentive.delete');
			Route::post('updateStatus', 'Admin\IncentiveController@updateStatus')->name('admin.incentive.updateStatus');
			Route::get('/{id}/details', 'Admin\IncentiveController@details')->name('admin.incentive.details');
		});

		Route::group(['prefix'  =>   'vehicle'], function() {
			Route::get('/', 'Admin\VehicleController@index')->name('admin.vehicle.index');
			Route::get('/create', 'Admin\VehicleController@create')->name('admin.vehicle.create');
			Route::post('/store', 'Admin\VehicleController@store')->name('admin.vehicle.store');
			Route::get('/{id}/edit', 'Admin\VehicleController@edit')->name('admin.vehicle.edit');
			Route::post('/update', 'Admin\VehicleController@update')->name('admin.vehicle.update');
			Route::get('/{id}/delete', 'Admin\VehicleController@delete')->name('admin.vehicle.delete');
			Route::post('updateStatus', 'Admin\VehicleController@updateStatus')->name('admin.vehicle.updateStatus');
			Route::get('/{id}/details', 'Admin\VehicleController@details')->name('admin.vehicle.details');
		});

		Route::group(['prefix'  =>   'boys'], function() {
			Route::get('/', 'Admin\DeliveryBoyController@index')->name('admin.boys.index');
			Route::get('/create', 'Admin\DeliveryBoyController@create')->name('admin.boys.create');
			Route::post('/store', 'Admin\DeliveryBoyController@store')->name('admin.boys.store');
			Route::get('/{id}/edit', 'Admin\DeliveryBoyController@edit')->name('admin.boys.edit');
			Route::post('/update', 'Admin\DeliveryBoyController@update')->name('admin.boys.update');
			Route::get('/{id}/delete', 'Admin\DeliveryBoyController@delete')->name('admin.boys.delete');
			Route::post('updateStatus', 'Admin\DeliveryBoyController@updateStatus')->name('admin.boys.updateStatus');
			Route::get('/{id}/details', 'Admin\DeliveryBoyController@details')->name('admin.boys.details');
			Route::get('/driver/location', 'Admin\DeliveryBoyController@showLivelocations')->name('admin.driver.livelocation.index');
			Route::get('/{id}/orders', 'Admin\DeliveryBoyController@orders')->name('admin.boys.orders');
			Route::get('/{id}/earnings', 'Admin\DeliveryBoyController@earnings')->name('admin.boys.earnings');
		});

		Route::group(['prefix'  =>   'restaurant'], function() {
			Route::get('/', 'Admin\RestaurantController@index')->name('admin.restaurant.index');
			Route::get('/create', 'Admin\RestaurantController@create')->name('admin.restaurant.create');
			Route::post('/store', 'Admin\RestaurantController@store')->name('admin.restaurant.store');
			Route::get('/{id}/edit', 'Admin\RestaurantController@edit')->name('admin.restaurant.edit');
			Route::post('/update', 'Admin\RestaurantController@update')->name('admin.restaurant.update');
			Route::get('/{id}/delete', 'Admin\RestaurantController@delete')->name('admin.restaurant.delete');
			Route::post('updateStatus', 'Admin\RestaurantController@updateStatus')->name('admin.restaurant.updateStatus');
			Route::get('/{id}/details', 'Admin\RestaurantController@details')->name('admin.restaurant.details');
			Route::get('/{id}/items', 'Admin\RestaurantController@items')->name('admin.restaurant.items');
			Route::get('/{id}/itemcreate', 'Admin\RestaurantController@itemcreate')->name('admin.restaurant.itemcreate');
			Route::get('/{id}/itemedit', 'Admin\RestaurantController@itemedit')->name('admin.restaurant.itemedit');
			Route::get('/{id}/restaurant/{itemId}/itemdelete', 'Admin\RestaurantController@itemdelete')->name('admin.restaurant.itemdelete');
			Route::post('updateItemStatus', 'Admin\RestaurantController@updateItemStatus')->name('admin.restaurant.updateItemStatus');
			Route::post('/itemstore', 'Admin\RestaurantController@itemstore')->name('admin.restaurant.itemstore');
			Route::post('/itemupdate', 'Admin\RestaurantController@itemupdate')->name('admin.restaurant.itemupdate');
			Route::get('/{id}/transactions', 'Admin\RestaurantController@transactions')->name('admin.restaurant.transactions');
			Route::get('/{id}/orders', 'Admin\RestaurantController@orders')->name('admin.restaurant.orders');
			Route::get('/{id}/reviews', 'Admin\RestaurantController@reviews')->name('admin.restaurant.reviews');
			Route::get('/{id}/change_password', 'Admin\RestaurantController@change_password')->name('admin.restaurant.change_password');
			Route::post('/updatePassword', 'Admin\RestaurantController@updatePassword')->name('admin.restaurant.updatepassword');
		});

		Route::group(['prefix'  =>   'order'], function() {
			Route::get('/', 'Admin\OrderController@index')->name('admin.order.index');
			Route::get('/{id}/details', 'Admin\OrderController@details')->name('admin.order.details');
			Route::get('/new', 'Admin\OrderController@new')->name('admin.order.new');
			Route::get('/ongoing', 'Admin\OrderController@ongoing')->name('admin.order.ongoing');
			Route::get('/delivered', 'Admin\OrderController@delivered')->name('admin.order.delivered');
			Route::get('/cancelled', 'Admin\OrderController@cancelled')->name('admin.order.cancelled');
			Route::post('/assignboy', 'Admin\OrderController@assignDeliveryBoy')->name('admin.order.assignboy');
			Route::get('/sales', 'Admin\OrderController@salesReport')->name('admin.order.sales');
			Route::get('/online-transactions', 'Admin\OrderController@onlineTransactions')->name('admin.order.onlinetransactions');
			Route::get('/report', 'Admin\OrderController@report')->name('admin.order.report');
			Route::get('/{id}/report-details', 'Admin\OrderController@report_details')->name('admin.order.report_details');
		});

		Route::group(['prefix'  =>   'coupon'], function() {
			Route::get('/', 'Admin\CouponController@index')->name('admin.coupon.index');
			Route::get('/create', 'Admin\CouponController@create')->name('admin.coupon.create');
			Route::post('/store', 'Admin\CouponController@store')->name('admin.coupon.store');
			Route::get('/{id}/edit', 'Admin\CouponController@edit')->name('admin.coupon.edit');
			Route::post('/update', 'Admin\CouponController@update')->name('admin.coupon.update');
			Route::get('/{id}/delete', 'Admin\CouponController@delete')->name('admin.coupon.delete');
			Route::post('updateStatus', 'Admin\CouponController@updateStatus')->name('admin.coupon.updateStatus');
			Route::get('/{id}/details', 'Admin\CouponController@details')->name('admin.coupon.details');
		});
	});

});
?>