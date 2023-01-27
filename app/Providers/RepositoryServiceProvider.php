<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BannerContract;
use App\Repositories\BannerRepository;
use App\Contracts\AdminContract;
use App\Repositories\AdminRepository;
use App\Contracts\UserContract;
use App\Repositories\UserRepository;
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;
use App\Contracts\BlogContract;
use App\Repositories\BlogRepository;
use App\Contracts\NotificationContract;
use App\Repositories\NotificationRepository;
use App\Contracts\CousineContract;
use App\Repositories\CousineRepository;
use App\Contracts\LocationContract;
use App\Repositories\LocationRepository;
use App\Contracts\CommissionContract;
use App\Repositories\CommissionRepository;
use App\Contracts\IncentiveContract;
use App\Repositories\IncentiveRepository;
use App\Contracts\VehicleContract;
use App\Repositories\VehicleRepository;
use App\Contracts\DeliveryBoyContract;
use App\Repositories\DeliveryBoyRepository;
use App\Contracts\RestaurantContract;
use App\Repositories\RestaurantRepository;
use App\Contracts\OrderContract;
use App\Repositories\OrderRepository;
use App\Contracts\CartContract;
use App\Repositories\CartRepository;
use App\Contracts\CouponContract;
use App\Repositories\CouponRepository;
use App\Contracts\RestaurantCouponContract;
use App\Repositories\RestaurantCouponRepository;
use App\Contracts\LeadContract;
use App\Repositories\LeadRepository;

use App\Contracts\ItemContract;
use App\Repositories\ItemRepository;

use App\Contracts\QuatationContract;
use App\Repositories\QuatationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        AdminContract::class                =>  AdminRepository::class,
        BannerContract::class               =>  BannerRepository::class,
        UserContract::class                 =>  UserRepository::class,
        CategoryContract::class             =>  CategoryRepository::class,
        BlogContract::class                 =>  BlogRepository::class,
        NotificationContract::class         =>  NotificationRepository::class,
        CousineContract::class              =>  CousineRepository::class,
        LocationContract::class             =>  LocationRepository::class,
        CommissionContract::class           =>  CommissionRepository::class,
        IncentiveContract::class            =>  IncentiveRepository::class,
        VehicleContract::class              =>  VehicleRepository::class,
        DeliveryBoyContract::class          =>  DeliveryBoyRepository::class,
        RestaurantContract::class           =>  RestaurantRepository::class,
        OrderContract::class                =>  OrderRepository::class,
        CartContract::class                 =>  CartRepository::class,
        CouponContract::class               =>  CouponRepository::class,
        RestaurantCouponContract::class     =>  RestaurantCouponRepository::class,
        LeadContract::class                 =>  LeadRepository::class,
        ItemContract::class                 =>  ItemRepository::class,
        QuatationContract::class            =>  QuatationRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
