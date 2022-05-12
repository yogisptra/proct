<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Repositories\TransactionJobRepository;
class ReminderTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reminderTransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Reminder Transaction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TransactionJobRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->repository->reminderTransaction();
        Log::info('CRON reminderTransaction: Finish');
    }
}
