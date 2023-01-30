<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $token;
 /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.regconfirm')
            ->subject('Confirma tu registro en Suspensión Lujan')
            ->with(['name'=>$this->name,
                'token'=>$this->token,]
            );
    }
}
