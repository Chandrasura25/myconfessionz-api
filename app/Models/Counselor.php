<?php

namespace App\Models;

use App\Models\CounselorReply;
use App\Models\Message;
use App\Models\Counselorcomment;
use App\Models\CounselorLikePost;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CounselorLikeReply;
use App\Models\CounselorLikeComment;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counselor extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'counselors';
    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "image",
        "counseled_clients",
        "counseling_field",
        "earnings",
        "satisfied_clients",
        'dob',
        'gender',
        'password',
        'country',
        'state',
        'recovery_question1',
        'answer1',
        'recovery_question2',
        'answer2',
        'recovery_question3',
        'answer3',
        'verified'

    ];

    public function counselorcomments(){
        return $this->hasMany(Counselorcomment::class);
    }

    public function counselorlikeposts(){
        return $this->hasMany(CounselorLikePost::class);
    }

    public function counselorlikecomments(){
        return $this->hasMany(CounselorLikeComment::class);
    }

    public function counselorlikereplies(){
        return $this->hasMany(CounselorLikeReply::class);
    }

    public function counselorreplies(){
        return $this->hasMany(CounselorReply::class);
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'counselor_id');
    }
    public function sentConversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function receivedConversations()
    {
        return $this->hasMany(Conversation::class, 'receiver_id');
    }

}
