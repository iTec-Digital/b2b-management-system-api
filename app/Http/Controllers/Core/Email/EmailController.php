<?php

namespace App\Http\Controllers\Core\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class EmailController extends Controller
{
    public static function AppSendEmail($EmailTo, $EmailSubject, $EmailMessage)
    {
        Mail::send([], [], function ($message) use ($EmailTo, $EmailSubject, $EmailMessage) {
            $message->to($EmailTo)
                ->from("nayeem@dotlogic.xyz", "C&F")
                ->subject($EmailSubject)
                ->setBody($EmailMessage, 'text/html');
        });
    }
}
