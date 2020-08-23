<?php

namespace App\Console;

use App\Console\Commands\PoGrGet;
use App\Console\Commands\PoGrGetMin;
use App\Console\Commands\PrMrpGet;
use App\Console\Commands\ClonePrMrp;
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
        PoGrGet::class,
        PoGrGetMin::class,
        PrMrpGet::class,
        ClonePrMrp::class  
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work')->hourly();
        
        //get GR debet S
        $schedule->command('po:gr')->everyMinute();

        //get GR debet H
        $schedule->command('po:gr-min')->cron('*/2 * * * *');

        //get pr mrp
        $schedule->command('MRP:GET')->timezone('Asia/Jakarta')->at('06:09');
        //clone
        $schedule->command('CLONE:MRP')->timezone('Asia/Jakarta')->at('06:15');

        //get pr mrp
        $schedule->command('MRP:GET')->timezone('Asia/Jakarta')->at('12:09');
        //clone
        $schedule->command('CLONE:MRP')->timezone('Asia/Jakarta')->at('12:15');

        //get pr mrp
        $schedule->command('MRP:GET')->timezone('Asia/Jakarta')->at('14:58');
        //clone
        $schedule->command('CLONE:MRP')->timezone('Asia/Jakarta')->at('15:02');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
