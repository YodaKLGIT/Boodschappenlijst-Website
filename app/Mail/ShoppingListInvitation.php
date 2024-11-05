<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Shoppinglist;

class ShoppingListInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $shoppinglist;

    /**
     * Create a new message instance.
     */
    public function __construct(Shoppinglist $shoppinglist)
    {
        $this->shoppinglist = $shoppinglist;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to Join Shopping List',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.shoppinglist-invitation',
            with: [
                'acceptUrl' => route('shoppinglist.accept', $this->shoppinglist->id),
                'declineUrl' => route('shoppinglist.decline', $this->shoppinglist->id),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
