<?php

namespace App\Models;

use App\Models\User;
use App\Models\Anoncomment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post',
        'category',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function anoncomments(){
        return $this->hasMany(Anoncomment::class);
    }
}
