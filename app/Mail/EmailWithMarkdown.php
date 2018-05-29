<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailWithMarkdown extends Mailable {

    use Queueable,
        SerializesModels;

    public $params = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params) {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown('emails.deals.emailWithMarkdown')->subject('Oferton | Mejores Ofertas del ' . date('H:i:s d-m-Y'));
    }

}
