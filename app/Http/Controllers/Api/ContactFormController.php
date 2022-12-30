<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Contact;

class ContactFormController extends Controller
{
    // function add(Request $req)
    // {
    //     $contact= new Contact;
    //     $contact->name=$req->name;
    //     $contact->email=$req->email;
    //     $contact->subject=$req->subject;
    //     $contact->message=$req->message;
    //     $request=$contact->save();
    //     if($request){
    //         return ["Result"=>"Data has been saved"];
    //     } else {
    //         return ["Result"=>"Failed"];
    //     }
    // }

    public function add(Request $req) {
 
        // Form validation
         $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject'=>'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json([
                'error'=>$validator->errors()
            ], 401);            
        }
        //  Store data in database
        Contact::create($req->all());
 
        //  Send mail to Application Admin
        // \Mail::send('emails.contactemail', array(
        //     'name' => $req->get('name'),
        //     'email' => $req->get('email'),
        //     'subject' => $req->get('subject'),
        //     'bodyMessage' => $req->get('message'),
        // ), function($message) use ($req){
        //     $message->from($req->email);
        //     $message->to('prakash.infotechsolz@gmail.com', 'Prakash')->subject($req->get('subject'));
        // });
        // return response()->json(['success' => 'The email has been sent.']);
    }
}
