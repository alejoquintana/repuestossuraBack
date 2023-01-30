<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Franquicia extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $mail;
    public $phone;
    public $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mail,$phone,$msg)
    {
        $this->name = $name;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.franquicia')
            ->with(['name'=>$this->name,
                'mail'=>$this->mail,
                'phone'=>$this->phone,
                'msg'=>$this->msg]
            );
    }
}
