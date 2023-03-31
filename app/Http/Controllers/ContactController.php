<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //contact us page
    public function contact(){
        return view('user.contact.contact');
    }

    //send message
    public function sendMessage(Request $request){
        $data = $this->getContactData($request);

        Contact::create($data);

        return redirect()->route('user#contact')->with(['sendSuccess' => 'Your Message Sends Successfully!..']);

    }

    //get contact data
    private function getContactData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
    }

}
