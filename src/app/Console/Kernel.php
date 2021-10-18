<?php

namespace App\Console;

use App\Jobs\GenresSeedingJob;
use App\Jobs\MoviesSeedingJob;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new GenresSeedingJob())->everyMinute(\env('TASK_TIME', '2:00'))->when(function () {
            //execute the scheduler if the genres table is empty
            return 0 === Genre::count();
        });
        $schedule->job(new MoviesSeedingJob())->everyMinute(\env('TASK_TIME', '2:00'))->when(function () {
            //execute the scheduler as long as we didn't completed the required num of movies
            return \config('movies.num_of_records') > Movie::count();
        });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
