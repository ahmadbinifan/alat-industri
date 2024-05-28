<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipment_license;
use App\Models\approval_equipment_license;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\reminderMail;

class ReminderCommand extends Command
{

    protected $signature = 'reminder:run';
    protected $description = 'Send reminders';

    public function handle()
    {
        $bodyEmail = [
            'subject' => 'Reminder of certificates industrial that have not yet been re-certified'
        ];
        $eq = Equipment_license::where('status', 'need_re_license')->get();
        $approvalNames = [];
        if ($eq->count() == 0) {
            \Log::info("Data tidak ditemukan.");
        } else {
            foreach ($eq as $value) {
                $doc_no = $value->doc_no;
                $allApproval = approval_equipment_license::where('doc_no', $doc_no)->distinct()->get('fullname');

                foreach ($allApproval as $approval) {
                    $fullname = $approval->fullname;
                    if (!in_array($fullname, $approvalNames)) {
                        $approvalNames[] = $fullname;
                    }
                }
            }

            foreach ($approvalNames as $name) {
                $user =  User::where('fullname', $name)->distinct('fullname')->first();
                if ($user) {
                    Mail::to($user->email)->send(new reminderMail($user, $bodyEmail));
                }
            }
        }
    }
}
