<?php

namespace App\Providers;

use App\Models\School;
use App\Observers\SchoolObserver;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        if (env('APP_DEBUG')) {
            DB::listen(function ($query) {
                Log::channel('db')->info($query->sql . '=' . $query->time / 1000 . 's');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        School::observe(SchoolObserver::class);

        Auth::provider('api-eloquent', function ($app, $config) {
            return new ApiEloquentUserProvider($app['hash'], $config['model']);
        });

    }
}
