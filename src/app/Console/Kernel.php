<?php

namespace App\Console;

use App\Jobs\GenresSeedingJob;
use App\Jobs\MoviesSeedingJob;
use App\Models\Genre;
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
        $schedule->job(new MoviesSeedingJob())->dailyAt(\config('scheduler.task_time'))->when(function () {
            //execute the scheduler as long as we didn't completed the required num of movies
            return \config('movies.fetched_num_of_movies') < \config('movies.num_of_records');
        });
        $schedule->job(new GenresSeedingJob())->dailyAt(\config('scheduler.task_time'))->when(function () {
            //execute the scheduler as long as we didn't fetch genres
            return 0 === Genre::count();
        });
        // $schedule->job(new MoviesSeedingJob())->everyMinute();
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
