<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counselor_like_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('counselor_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('comment_id');
            $table->foreign('counselor_id')->references('id')->on('counselors')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('counselorcomments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_like_comments');
    }
};
