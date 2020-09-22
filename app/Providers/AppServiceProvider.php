<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Validator::extend('SameOld_password', function ($attribute,$value,$parameters,$validator){
            return Hash::check($value, Auth::user()->password);
        });

        Validator::extend('NotSameOld_password', function ($attribute,$value,$parameters,$validator){
            return !Hash::check($value, Auth::user()->password);
        });

    }

}
