<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailSuccessWidhdrawalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data, $note;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $note)
    {
        $this->data = $data;
        $this->note = $note;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $note = $this->note;
        $email = new \App\Mail\SuccessWidhdrawal($data, $note);
        Mail::to($data->hasUser->email)->send($email);
    }
}
