<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\notificationEmail;
use App\Models\detail_equipment;

class reminderLicense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $person;
    public $body;
    public function __construct($person, $body)
    {
        $this->person = $person;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        detail_equipment::where('doc_no', $this->body['doc_no'])->update([
            'status' => 'open'
        ]);
        Mail::to($this->person->email)->send(new notificationEmail($this->person, $this->body));
    }
}
