<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

class CronJobController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function callCron($cron_name){
        try {
            Artisan::call($cron_name);
            return view()->make('welcome');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
        
    }

    public function checkSchedule(){
        try {
            $schedule = app(Schedule::class);
            $kernel = app(\App\Console\Kernel::class)->registerCommands($schedule);
            
            $scheduledCommands = collect($schedule->events())
                ->map(function ($event) {
                    $expression = \Cron\CronExpression::factory($event->expression);
    
                    var_dump([
                        'command' => $event->command,
                        'expression' => $event->expression,
                        'next-execution' => $expression->getNextRunDate()
                    ]);
                });
    
            return $scheduledCommands;
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
        
    }
}
