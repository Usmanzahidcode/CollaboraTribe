<?php

namespace App\Jobs;

use App\Mail\RenewVerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RenewEmailTokenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

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
        Mail::to($this->to)->send(new RenewVerificationToken($this->maildata));
    }
}
