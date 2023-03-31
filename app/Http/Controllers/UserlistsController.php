<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class UserlistsController extends Controller
{
    //direct userlists page
    public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.list',compact('users'));
    }

    //change user role
    public function changeRole(Request $request){
        $updateSource =[
            'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    //customer messsage
    public function customerMessage(){
        $message = Contact::get();

        return view('admin.user.messageList',compact('message'));
    }
}
