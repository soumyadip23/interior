<?php
use Illuminate\Http\Request;
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

// Auth::routes();
Route::get('command', function () {
	/* php artisan migrate */
    \Artisan::call('migrate:fresh --seed');
    dd("Done");
});

require 'admin.php';
require 'api.php';
require 'vendor.php';
require 'staff.php';



