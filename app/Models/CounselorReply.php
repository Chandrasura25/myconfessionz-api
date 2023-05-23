<?php

namespace App\Models;

use App\Models\Counselor;
use App\Models\Counselorcomment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CounselorReply extends Model
{
    use HasFactory;
    protected $fillable = ['reply', 'comment_id', 'counselor_id'];

    public function comment(){
        return $this->belongsTo(Counselorcomment::class);
    }

    public function user(){
        return $this->belongsTo(Counselor::class);
    }
}
