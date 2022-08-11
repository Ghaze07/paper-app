<?php

namespace App\Providers;

use App\Repositories\SubjectRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ISubject;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //repository mapping
        $this->app->bind(ISubject::class, SubjectRepository::class);
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
