<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;

    protected $fillable  = ['key'];

    public function chatMessages(){
        return $this->hasMany(ChatMessage::class);
    }

    public function chatParticipants(){
        return $this->hasMany(ChatParticipant::class);
    }

    public function getUserChats($id){
        $chat_ids = ChatParticipant::where('user_id', $id)->pluck('chat_id');
        return Chat::whereIn('id', $chat_ids)->get();
    }

    public function getOtherParticipant($id){
        $otherUser = ChatParticipant::where('id', $this->id)->where('user_id', '!=', $id)->first();
        return User::findOrFail($otherUser->id);
    }

}
