<?php

namespace App\Jobs;

use App\Http\services\TMDService;
use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MoviesSeedingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(TMDService $movieService)
    {
        //TMDB returns only 20 movies per page
        $pageNumber = \intval(Movie::count() / 20) + 1; //starts from 1 not 0
        $movieService->getRecentlyMovies($pageNumber);
        $movieService->getTopRatedMovies($pageNumber);
    }
}
