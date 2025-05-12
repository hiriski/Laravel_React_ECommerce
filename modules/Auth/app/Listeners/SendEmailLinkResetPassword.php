<?php

namespace Modules\Auth\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\ResetPasswordInstruction;
use Modules\Auth\Events\RequestedResetPassword;

class SendEmailLinkResetPassword
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /** 
     * Handle the event.
     */
    public function handle(RequestedResetPassword $event)
    {
        try {
            Mail::to($event->data['email'])->send(new ResetPasswordInstruction([
                'link'      => $event->data['link'],
                'email'     => $event->data['email'],
            ]));
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
