<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegalosEmpresariales extends Mailable
{
    use Queueable, SerializesModels;

    public $phone;
    public $email;
    //public $image;
    
    public $products;
   public  $name;
    public $qty;
    public $date;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($phone='',
        $email='',
        //$image='',
        
        $products='',
        $name='',
        $qty='',
        $date=''
    )
    {
        
        $this->phone =$phone ;
        $this->email =$email ;
        //$this->image =$image ;
    
        $this->products =$products ;
        $this->name =$name ;
        $this->qty =$qty ;
        $this->date =$date ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.regalos-empresariales')
            ->with([
                'phone'=>$this->phone,
                'email'=>$this->email,
              //  'image'=>$this->image,
                
                'products'=>$this->products,
                'name'=>$this->name,
                'qty'=>$this->qty,
                'date'=>$this->date
            ]);
    }
}
