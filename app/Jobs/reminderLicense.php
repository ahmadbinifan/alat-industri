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
use App\Models\Equipment_license;

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
        Equipment_license::where('doc_no', $this->body['doc_no'])->update([
            'status' => 'need_re_license'
        ]);
        Mail::to($this->person->email)->send(new notificationEmail($this->person, $this->body));
    }
}
