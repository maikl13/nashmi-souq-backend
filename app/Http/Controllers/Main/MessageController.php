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

        if($sender->id == $recipient->id) 
            return response()->json('خطأ!', 500);

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
            return response()->json('حدث خطأ ما! من فضلك حاول مجداد', 500);
        }
    }


    public function get_conversation($user, Request $request)
    {
        $recipient = User::where('username', $user)->first();
        $conversation = Auth::user()->conversations_with( $recipient )->first();

        if($conversation){
            foreach ($conversation->messages()->where('recipient_id', auth()->user()->id)->unseen()->get() as $message) {
                $message->seen = now(); // date("Y-m-d H:i:s")
                $message->save();
            }
            return response()->json( view('main.layouts.partials.conversation-messages')->with('conversation', $conversation)->render() , 200);
        }

        return response()->json('', 200);
    }

    public function get_conversations()
    {        
        return response()->json( view('main.layouts.partials.latest-conversations')->render() , 200);
    }

    public function get_unseen_messages_count()
    {
        return response()->json(Auth::user()->recieved_messages()->unseen()->count(), 200);
    }
}
