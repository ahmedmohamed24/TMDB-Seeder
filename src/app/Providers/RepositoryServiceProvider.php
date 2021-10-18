<?php

namespace App\Providers;

use App\Http\Repository\Movie\IMovieRepository;
use App\Http\Repository\Movie\MovieRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(IMovieRepository::class, MovieRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
