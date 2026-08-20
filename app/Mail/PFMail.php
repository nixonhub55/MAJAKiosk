<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class PFMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;
    
    /**
     * Create a new message instance.
     */
    public function __construct($data_request)
    {
        $this->data = $data_request;
    }

    public function build()
    {
        $email = $this->subject($this->data['subject'])
            ->view('mail.pf_mailer_msg')
            ->with(['data' => $this->data]);

        // Attach files manually
        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                if (file_exists($attachment['tmp_name'])) {
                    $email->attach($attachment['tmp_name'], [
                        'as' => $attachment['name'],
                        'mime' => $attachment['type'],
                    ]);
                }
            }
        }

        return $email;
    }

   /*  //Get the message envelope. 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'P F Mail',
        );
    } */

    /* //Get the message content definition.  
    public function content(): Content
    {
        return new Content(
            view: 'mail.pf_mailer_msg',
            with: ['data' => $this->data] // pass data to view
        );
    } */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

   /*  public function attachments(): array
    {
        $attachments = [];
    
        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) { 
                $attachments[] = [
                    'path' => $attachment['tmp_name'],
                    'name' => $attachment['name'],
                    'mime' => $attachment['type'],
                ];
            }
        }  


       return $attachments;
    } */
}
