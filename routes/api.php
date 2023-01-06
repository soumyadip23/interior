<?php

Route::post('login', 'Api\AuthController@authenticate');
Route::post('register', 'Api\AuthController@register');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'Api\AuthController@getAuthenticatedUser');
    Route::post('profile/update', 'Api\AuthController@updateProfile');
    Route::post('user/device/update', 'Api\AuthController@updateDeviceDetails');

    Route::get('home', 'Api\CommonController@fetchHomeScreenData');
    Route::post('search', 'Api\CommonController@serachData');

    Route::get('restaurant/list', 'Api\RestaurantController@list');
    Route::get('restaurant/details/{id}', 'Api\RestaurantController@details');
    Route::post('restaurant/single', 'Api\RestaurantController@singleData');
    Route::get('cuisine/restaurant/list/{cuisineId}', 'Api\RestaurantController@cuisineWiseRestaurants');
    Route::post('restaurant/review/add', 'Api\RestaurantController@addReview');

    Route::get('address/list/{id}', 'Api\AddressController@addressList');
    Route::post('address/add', 'Api\AddressController@addAddress');
    Route::post('address/update', 'Api\AddressController@updateAddress');
    Route::get('address/delete/{id}', 'Api\AddressController@deleteAddress');

    Route::get('order/list/{id}', 'Api\OrderController@list');
    Route::get('order/details/{id}', 'Api\OrderController@details');
    Route::post('order/create', 'Api\OrderController@create');

    Route::get('cart/list/{userId}', 'Api\CartController@list');
    Route::post('cart/add', 'Api\CartController@add');
    Route::post('cart/update', 'Api\CartController@update');
    Route::get('cart/delete/{id}', 'Api\CartController@delete');
    Route::get('cart/clear/{userId}', 'Api\CartController@clear');

    Route::get('coupon/list', 'Api\CommonController@couponList');
    Route::get('cuisine/list', 'Api\CommonController@cuisineList');

    Route::post('suggestion/add', 'Api\CommonController@addSuggestion');
    Route::post('user/order/cancel', 'Api\OrderController@cancelOrder');
    
    Route::post('restaurant/favourite/add', 'Api\CommonController@addFavouriteRestaurant');
    Route::post('restaurant/favourite/remove', 'Api\CommonController@removeFavouriteRestaurant');
    Route::get('user/favourite/restaurant/{userId}', 'Api\CommonController@getFavouriteRestaurant');

    Route::post('wallet/credit', 'Api\WalletController@walletCredit');
    Route::get('wallet/user/{userId}', 'Api\WalletController@userWallets');
});

Route::get('user/notification/list/{userId}', 'Api\CommonController@notificationList');

//APIs for restaurant app
Route::post('restaurant-login', 'Api\RestaurantManagementController@login');
Route::get('restaurant-details/{id}', 'Api\RestaurantManagementController@details');
Route::get('restaurant-wise-new-orders/{id}', 'Api\RestaurantManagementController@newOrders');
Route::get('restaurant-wise-delivered-orders/{id}', 'Api\RestaurantManagementController@deliveredOrders');
Route::get('restaurant-wise-cancelled-orders/{id}', 'Api\RestaurantManagementController@cancelledOrders');
Route::get('restaurant-wise-ongoing-orders/{id}', 'Api\RestaurantManagementController@ongoingOrders');
Route::post('restaurant-accept-order', 'Api\RestaurantManagementController@acceptOrder');
Route::post('restaurant-cancel-order', 'Api\RestaurantManagementController@cancelOrder');
Route::get('restaurant-order-details/{id}', 'Api\RestaurantManagementController@orderDetails');
Route::get('restaurant-dashboard/{id}', 'Api\RestaurantManagementController@dashboardData');
Route::get('restaurant/notification/list/{id}', 'Api\RestaurantManagementController@notificationList');
Route::get('restaurant-wise-items/{id}', 'Api\RestaurantManagementController@restaurantWiseItems');
Route::get('restaurant-wise-categories/{id}', 'Api\RestaurantManagementController@restaurantWiseCategories');
Route::post('restaurant/item/add', 'Api\RestaurantManagementController@addItem');
Route::post('restaurant/item/update', 'Api\RestaurantManagementController@updateItem');
Route::get('restaurant/item/delete/{itemId}', 'Api\RestaurantManagementController@deleteItem');
Route::post('restaurant/user/find', 'Api\RestaurantManagementController@findUserWithMobile');
Route::post('restaurant-items-for-order', 'Api\RestaurantManagementController@itemListForOrder');
Route::get('restaurant-cart/list/{userId}', 'Api\CartController@list');
Route::post('restaurant-cart/add', 'Api\CartController@add');
Route::post('restaurant-cart/update', 'Api\CartController@update');
Route::get('restaurant-cart/delete/{id}', 'Api\CartController@delete');
Route::get('restaurant-cart/clear/{userId}', 'Api\CartController@clear');
Route::post('restaurant/order/create', 'Api\RestaurantManagementController@createOrder');
Route::post('restaurant/offer/create', 'Api\RestaurantManagementController@createOffer');
Route::post('restaurant/offer/update', 'Api\RestaurantManagementController@updateOffer');
Route::get('restaurant/offer/delete/{id}', 'Api\RestaurantManagementController@deleteOffer');
Route::get('restaurant/offer/list/{restaurantId}', 'Api\RestaurantManagementController@offerList');
Route::post('restaurant/report/date-wise', 'Api\RestaurantReportController@dateWiseReport');
Route::post('restaurant/report/date-wise-transactions', 'Api\RestaurantReportController@dateWiseReport');
Route::post('restaurant/report/item-wise', 'Api\RestaurantReportController@itemWiseReport');
Route::post('restaurant/data/update', 'Api\RestaurantManagementController@updateRestaurantProfile');
Route::post('restaurant/password/update', 'Api\RestaurantManagementController@passwordUpdate');
Route::post('restaurant/settings/update', 'Api\RestaurantManagementController@updateRestaurantSettingsData');
Route::get('restaurant/category/list/{restaurantId}', 'Api\RestaurantManagementController@categoryList');
Route::post('restaurant/category/add', 'Api\RestaurantManagementController@addCategory');
Route::post('restaurant/category/update', 'Api\RestaurantManagementController@updateCategory');
Route::get('restaurant/category/delete/{id}', 'Api\RestaurantManagementController@deleteCategory');
Route::get('restaurant/category/items/{id}', 'Api\RestaurantManagementController@categoryWiseItems');
Route::post('restaurant/delivery/config/update', 'Api\RestaurantManagementController@setupDeliveryConfig');
Route::get('restaurant/delivery/config/{id}', 'Api\RestaurantManagementController@restaurantWiseDeliveryConfig');
Route::get('restaurant/timing/{id}', 'Api\RestaurantManagementController@restaurantWiseTimings');
Route::post('restaurant/timing/update', 'Api\RestaurantManagementController@setupTiming');
Route::get('restaurant/transactions/{id}', 'Api\RestaurantManagementController@restaurantPayments');
Route::get('restaurant/monthly/order/count/{id}', 'Api\RestaurantManagementController@monthlyOrderReport');
Route::get('restaurant/monthly/sales/{id}', 'Api\RestaurantManagementController@monthlySalesReport');

//APIs for delivery boy app
Route::post('delivery-boy-login', 'Api\DeliveryBoyManagementController@login');
Route::post('delivery-boy-register', 'Api\DeliveryBoyManagementController@register');
Route::get('delivery-boy-details/{id}', 'Api\DeliveryBoyManagementController@details');
Route::get('search-new-orders-for-boy/{id}', 'Api\DeliveryBoyManagementController@searchNewOrders');
Route::get('ongoing-orders-for-boy/{id}', 'Api\DeliveryBoyManagementController@ongoingOrders');
Route::get('delivered-orders-for-boy/{id}', 'Api\DeliveryBoyManagementController@deliveredOrders');
Route::post('rider-started', 'Api\DeliveryBoyManagementController@riderStarted');
Route::post('reached-restaurant', 'Api\DeliveryBoyManagementController@reachedRestaurant');
Route::post('order-picked', 'Api\DeliveryBoyManagementController@orderPicked');
Route::post('order-delivered', 'Api\DeliveryBoyManagementController@orderDelivered');
Route::get('boy-sos-notification/{id}', 'Api\DeliveryBoyManagementController@sosNotify');
Route::get('boy/notifications/{id}', 'Api\DeliveryBoyManagementController@notifications');
Route::post('boy/availibility', 'Api\DeliveryBoyManagementController@updateAvailibility');
Route::get('boy/earnings/{id}', 'Api\DeliveryBoyManagementController@earnings');
Route::post('boy-profile-update', 'Api\DeliveryBoyManagementController@updateProfile');
Route::post('boy-password-update', 'Api\DeliveryBoyManagementController@updatePassword');