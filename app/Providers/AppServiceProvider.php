<?php

namespace App\Providers;

use App\Repositories\PaperRepository;
use App\Repositories\Interfaces\IPaper;
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
        $this->app->bind(IPaper::class, PaperRepository::class);
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
