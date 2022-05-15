<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use Illuminate\Support\Str;


class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeChat(Request $request)
    {

        // $request->validate([
        //     "participants" => "required",
        // ]);  

        // $chats1 = (array) ChatParticipant::where('user_id', (int)($request->participants)[0])->pluck('chat_id');
        // $chats2 = (array) ChatParticipant::where('user_id', (int)($request->participants)[1])->pluck('chat_id');

        
        // $commonChat= (array_intersect($chats1, $chats2));
        // //$chat = Chat::where('id', $commonChat)->first();
        
        // print_r($commonChat);
        // //var_dump( $chats1);
        // echo "next-------------------";
        // print_r($chats2);

        return;
        // if(is_null($chats1) && is_null($chats2)){
        //     echo 'here';
        //     return 'here';
        //     exit;
        //     // $key = Str::random(15);
        //     // $chat = Chat::create([
        //     //     "key" => $key,
        //     // ]);
        //     // return response()->JSON(['status' => 200, 'chatExists' => true]);
        // }
        // $commonChat= (array_intersect($chats1,$chats2))[0];
        // $chat = Chat::where('id', $commonChat)->first();


        // $participants = $request->participants;
        // foreach($participants as $participant){
        //     ChatParticipant::create([
        //         "chat_id" => $chat->id,
        //         "user_id" => $participant,
        //     ]);
        // }
        // return response()->JSON(['status' => 200, 'success' => true, 'chat' => $chat]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMessage(Request $request)
    {
        
        $chat = Chat::where('key', $request->key)->first();
        
        if(is_null($chat)){
            $chat = Chat::create([
                'key' => $request->key,
            ]);
        }

        $chatMsg = ChatMessage::create([
            'chat_id' => $chat->id,
            'key' => $chat->key,
            'sender_id' => $request->sender_id,
            'reciever_id' => $request->reciever_id,
        ]);

        return response()->JSON(['status' => 200]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
