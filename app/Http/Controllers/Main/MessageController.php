<?php

namespace App\Http\Controllers\Main;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|min:1|max:10000',
            'recipient' => 'required|exists:users,username'
        ]);

        $sender = Auth::user();
        $recipient = User::where('username', $request->recipient)->first();

        $conversation = Auth::user()->conversations_with( $recipient )->first();
        
        if(!$conversation){
            $conversation = new Conversation;
            $conversation->uid = uniqid('', true);
            $conversation->sender_id = $sender->id;
            $conversation->recipient_id = $recipient->id;
        }
        // save conversation anyway to update updated_at field 
        // to make it appear top in the latest conversations
        $conversation->save();
        
        $message = new Message;
        $message->message = $request->message;
        $message->conversation_id = $conversation->id;
        $message->sender_id = $sender->id;
        $message->recipient_id = $recipient->id;
        
        if($message->save()){
            event(new NewMessage($message));
            return response()->json(
                [
                    'message' => view('main.layouts.partials.conversation-messages')->with('conversation', $conversation)->render(),
                    'conversation_id' => $conversation->id
                ] , 200);
        } else {
            return response()->json('An error occured, please try again', 500);
        }
    }


    public function get_conversation($user, Request $request)
    {
        $recipient = User::where('username', $user)->first();
        $conversation = Auth::user()->conversations_with( $recipient )->first();
        
        if($conversation){
            return response()->json( view('main.layouts.partials.conversation-messages')->with('conversation', $conversation)->render() , 200);
        }

        return response()->json('', 200);
    }

    public function get_conversations()
    {        
        return response()->json( view('main.layouts.partials.latest-conversations')->render() , 200);
    }
}
