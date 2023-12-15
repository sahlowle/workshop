<?php

namespace App\Mail;

use App\Models\Device;
use App\Models\Guarantee;
use App\Models\Order;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $blade;
    public $order;
    public $devices;
    public $questions;
    public $guarantees;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order,$blade)
    {
        $this->order = $order;
        $this->blade = $blade;
        $this->devices = Device::all();
        $this->questions = Question::all();
        $this->guarantees= Guarantee::all();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New Invoice',
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
            view: $this->blade,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
