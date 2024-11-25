<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Productlist;

class ShoppingListInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $productlist;

    public function __construct(Productlist $productlist)
    {
        $this->productlist = $productlist;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to Join List',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.shoppinglist-invitation',
            with: [
                'acceptUrl' => route('invitations.accept', $this->productlist->id),
                'declineUrl' => route('invitations.decline', $this->productlist->id),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
