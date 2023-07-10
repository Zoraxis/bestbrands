<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        View::composer('*', function($view)
        {
            $view->with('profile', Auth::user())
            ->with('categories', DB::table('category')->get())
            ->with('brands', DB::table('brand')->get())
            ->with('gpersonal', count(DB::table('personal')->where([
                ['user_id', Auth::id()],
                ['is_cart', 1],
            ]
            )->get()));
        });
    }
}
