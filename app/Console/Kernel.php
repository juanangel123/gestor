<?php

namespace App\Console;

use App\Repositories\AlertRepository;
use App\Repositories\ContractRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class
    ];


    /**
     * Kernel constructor.
     * @param Application $app
     * @param Dispatcher $events
     */
    public function __construct(
        Application $app,
        Dispatcher $events)
    {
        parent::__construct($app, $events);
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->command($this->sendAlerts())
            ->daily(); */
    }
}
