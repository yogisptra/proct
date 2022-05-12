<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailCancelCampaignerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data, $note, $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $comment, $note)
    {
        $this->data = $data;
        $this->comment = $comment;
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
        $comment = $this->comment;
        $email = new \App\Mail\CancelRegisterCampaigner($data, $comment, $note);
        Mail::to($data->email)->send($email);
    }
}
