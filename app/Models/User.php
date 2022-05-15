<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Reply;
use App\Models\StudySession;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'key',
        'password',
        'university_name',
        'hrs_per_day',
        'hrs_per_week',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function studySessions(){
        return $this->hasMany(StudySession::class);
    }

    public function getChat($otherUser){
        $chatMsg = ChatMessage::where(function ($query) use ($otherUser){
                                    $query->where('sender_id', $this->id)
                                    ->where('reciever_id', $otherUser->id);
                                })->orWhere(function ($query) use ($otherUser){
                                    $query->where('sender_id', $otherUser->id)
                                    ->where('reciever_id', $this->id);
                                })->first();

        if(isset($chatMsg)){
            return Chat::where('id', $chatMsg->chat_id)->first();
        } else {
            return null;
        }
        
        //return ChatMessage::whereIn('sender_id', array($this->id, $otherUser->id))->orWhere('reciever_id', array($this->id, $otherUser->id))->first();
    }
}
