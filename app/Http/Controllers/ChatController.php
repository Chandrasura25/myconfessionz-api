<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getMessages()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(Request $request)
    {
        event(new Message($request->input(key:'username'),$request->input(key:'message')));
    }

    /**
     * Display the specified resource.
     */
    public function getChatRooms(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
