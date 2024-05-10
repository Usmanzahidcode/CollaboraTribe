<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $maildata;
    protected $to;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $to)
    {
        $this->maildata = $data;
        $this->to = $to;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to)->send(new WelcomeMail(data1: $this->maildata));
    }
}
