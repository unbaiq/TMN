<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $link;

    public function __construct($name, $link)
    {
        $this->name = $name;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Complete Your TMN Membership Registration')
                    ->view('emails.membership_invite');
    }
}
