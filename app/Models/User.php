<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Anoncomment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usercode',
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
        'balance',
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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function anoncomments()
    {
        return $this->hasMany(Anoncomment::class);
    }

    public function likeposts()
    {
        return $this->hasMany(LikePost::class);
    }

    public function likecomments()
    {
        return $this->hasMany(LikeComment::class);
    }

    public function likereplies()
    {
        return $this->hasMany(LikeReply::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'counselor_id');
    }
}
