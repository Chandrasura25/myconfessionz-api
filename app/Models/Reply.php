<?php

namespace App\Models;

use App\Models\User;
use App\Models\Anoncomment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['reply', 'comment_id', 'user_id'];

    public function comment(){
        return $this->belongsTo(Anoncomment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
