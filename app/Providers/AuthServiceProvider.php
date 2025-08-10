<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Log;
use App\Models\Positions;
use App\Models\Restaurants;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [


//        'App\UserManager' => 'App\Policies\UserManagerPolicy',
//        'App\EventManager' => 'App\Policies\EventManagerPolicy',
//        'App\UserCustomer' => 'App\Policies\UserCustomerPolicy',
//        'App\EventCustomer' => 'App\Policies\EventCustomerPolicy',
//        'App\Booker' => 'App\Policies\BookerPolicy',
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
