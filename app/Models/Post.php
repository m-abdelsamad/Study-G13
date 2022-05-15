<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment'
    ];

    public function user(){
       return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function getreplies(){
        return Reply::where('post_id', $this->id)->get();
    }

    public function ownedByUser(){
        $user = auth()->user()->id;
        return $this->user_id == $user;
    }


}
