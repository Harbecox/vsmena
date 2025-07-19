<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Logs;
use App\Models\Positions;
use App\Models\Restaurants;
use App\Models\User;
use App\Policies\UserManagerPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [
        User::class => UserPolicy::class,
        Positions::class => UserPolicy::class,
        Restaurants::class => UserManagerPolicy::class,
        Event::class => UserPolicy::class,
        Logs::class => UserPolicy::class,

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
