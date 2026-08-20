<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\PFMail;

class MailController extends Controller
{
    public function PFMailer(Request $data)
    { 

       try {
          

            /* \Config::set('mail.mailers.smtp', [
                'transport' => 'smtp',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'encryption' => 'tls',
                'username' => 'onnix2559@gmail.com',
                'password' => 'jsdpxplkgfouqdco',
            ]);
        
            \Config::set('mail.default', 'smtp');
            \Config::set('mail.from.address', 'onnix2559@gmail.com');
            \Config::set('mail.from.name', 'Your Name');
            
        
            
            \Mail::to(['onnix2559@gmail.com'])
                  ->cc(['iso.nixon@ogis-gbg.com'])
                   ->send(new PFMail());  */

            return "Email sent successfully!";
       } catch (\Throwable $th) {
            return "❌ Error: " . $e->getMessage(); // Shows error on the page
       }
    }
}
