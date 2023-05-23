<?php

namespace App\Models;

use App\Models\Counselor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounselorLikeComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'counselor_id', 'comment_id'];

    public function counselor(){
        return $this->belongsTo(Counselor::class);
    }
}
