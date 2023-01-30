<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Contact;
use Mail;
use App\Mail\ContactEmail;

class ContactFormController extends Controller
{
    // Store Contact Form data
    public function ContactForm(Request $req) {
 
        // Form validation
         $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject'=>'required',
            'message' => 'required'
         ]);
         if ($validator->fails()) { 
     return response()->json(['error'=>$validator->errors()], 401);            
 }
        //  Store data in database
        Contact::create($req->all());
 
        //  Send mail to Application Admin
        \Mail::send('emails.contactemail', array(
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'subject' => $req->get('subject'),
            'bodyMessage' => $req->get('message'),
        ), function($message) use ($req){
            $message->from($req->email);
            $message->to('prakashmicrosoft658@gmail.com', 'Admin')->subject($req->get('subject'));
        });
        // return response()->json(['success' => 'The email has been sent.']);
        return redirect()->back()->with(['success' => 'Contact Form Submit Successfully']);
        
    }


}
