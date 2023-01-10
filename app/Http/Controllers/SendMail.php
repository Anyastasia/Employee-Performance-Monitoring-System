<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail as XMail;

class SendMail extends Controller
{
    //
    private $to;
    private $data = [];
    public function to($to) {
        $this->to = $to;
    }

    public function send($xdata) {
        $this->data = [
            "subject" => $xdata->subject,
            "body" => $xdata->body,
            "first_name" => $xdata->first_name,
        ];

        try {
            //code...
            Mail::to($this->to)->send(new XMail($this->data));
            // return response()->json(['check email']); 
        } catch (Exception $th) {
            //throw $th;
            
            // dd($th);
        }
    }
}
