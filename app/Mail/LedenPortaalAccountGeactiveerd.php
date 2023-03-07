<?php

namespace App\Mail;

use App\Models\Administration\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LedenPortaalAccountGeactiveerd extends Mailable
{
    use Queueable, SerializesModels;

    public Member $member;
    public string $activationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member, string $activationUrl)
    {
        $this->member = $member;
        $this->activationUrl = $activationUrl;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Leden Portaal Account Geactiveerd',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.memberportalcreated',
        );
    }
}
