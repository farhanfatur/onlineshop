<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Contract\CategoryInterface',
                'App\Repositories\CategoryRepositories');

        $this->app->bind('App\Repositories\Contract\ProductInterface', 
                'App\Repositories\ProductRepositories');

        $this->app->bind('App\Repositories\Contract\StaffInterface',
                'App\Repositories\StaffRepositories');

        $this->app->bind('App\Repositories\Contract\BankInterface', 
                'App\Repositories\BankRepositories');

        $this->app->bind('App\Repositories\Contract\CartInterface', 
                'App\Repositories\CartRepositories');

        $this->app->bind('App\Repositories\Contract\OrderBuyerInterface', 
                'App\Repositories\OrderBuyerRepositories');

        $this->app->bind('App\Repositories\Contract\ProvinceInterface',
                'App\Repositories\ProvinceRepositories');

        $this->app->bind('App\Repositories\Contract\CityInterface',
                'App\Repositories\CityRepositories');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
