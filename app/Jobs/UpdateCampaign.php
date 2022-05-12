<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class UpdateCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $donatur;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $donatur)
    {
        $this->data = $data;
        $this->donatur = $donatur;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $donaturMail = $this->donatur;
        foreach($donaturMail as $row){
            $email = new \App\Mail\UpdateCampaignMail($this->data, $row);
            Mail::to($row->email)->send($email);
        }
    }
}
