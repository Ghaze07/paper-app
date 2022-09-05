<?php

namespace App\Providers;

use App\Repositories\PaperRepository;
use App\Repositories\CourseRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\Interfaces\IPaper;
use App\Repositories\LectureRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ICourse;
use App\Repositories\AdmissionRepository;
use App\Repositories\Interfaces\IArticle;
use App\Repositories\Interfaces\ILecture;
use App\Repositories\Interfaces\ISubject;
use App\Repositories\Interfaces\IAdmission;
use App\Repositories\TestimonialRepository;
use App\Repositories\Interfaces\ITestimonial;

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
        $this->app->bind(ITestimonial::class, TestimonialRepository::class);
        $this->app->bind(ICourse::class, CourseRepository::class);
        $this->app->bind(ILecture::class, LectureRepository::class);
        $this->app->bind(IArticle::class, ArticleRepository::class);
        $this->app->bind(IAdmission::class, AdmissionRepository::class);
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
