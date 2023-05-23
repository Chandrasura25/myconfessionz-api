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
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('image');
            $table->integer('counseled_clients')->nullable();
            $table->string('counseling_field');
            $table->bigInteger('earnings')->default(0);
            $table->integer('satisfied_clients')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('country');
            $table->string('state');
            $table->string('password');
            $table->string('recovery_question1');
            $table->string('answer1');
            $table->string('recovery_question2');
            $table->string('answer2');
            $table->string('recovery_question3');
            $table->string('answer3');
            $table->string('verified')->default("false");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};