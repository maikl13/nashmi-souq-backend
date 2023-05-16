<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageRecieved;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Mail;

class ContactMessageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main.contact-us');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|min:1|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|min:1|max:255',
            'subject' => 'nullable|min:1|max:255',
            'message' => 'required|max:30000',
        ]);

        $contact_message = new ContactMessage;
        $contact_message->name = $request->name;
        $contact_message->email = $request->email;
        $contact_message->phone = $request->phone;
        $contact_message->subject = $request->subject;
        $contact_message->message = $request->message;
        $contact_message->save();

        //SendMail
        if (setting('email')) {
            Mail::to(setting('email'))
            ->send(new ContactMessageRecieved($contact_message->name, $contact_message->email, $contact_message->phone, $contact_message->subject, $contact_message->message));
        }

        return response()->json([
            'success' => 1,
            'message' => 'تم الإرسال بنجاح, سنقوم بالرد في أقرب وقت ممكن',
        ], 200);
    }
}
