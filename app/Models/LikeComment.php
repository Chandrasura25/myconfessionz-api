<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LikeComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'comment_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
