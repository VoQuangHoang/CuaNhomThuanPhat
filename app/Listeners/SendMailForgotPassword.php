<?php

namespace App\Listeners;

use App\Trails\MailTrait;
use Illuminate\Bus\Queueable;
use App\Events\ForgotPasswordEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailForgotPassword implements ShouldQueue
{
    use Queueable, MailTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ForgotPasswordEvent  $event
     * @return void
     */
    public function handle(ForgotPasswordEvent $event)
    {
        $this->initMailConfig();

        $content_mail = $event->content_mail;

        $customer = $event->customer;

        $email = $customer->email;

        Mail::send('mail.forgot_password', $content_mail, function ($msg) use ($email) {
            $msg->from(config('mail.from.address'), config('mail.from.name'));
            $msg->to($email, config('mail.from.name'))->subject('Lấy lại mật khẩu - Dotiva!');
        });
    }
}
