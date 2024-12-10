<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\Message;

use Illuminate\Support\Facades\DB;
class ChatController extends Controller
{

    public function createRoom($id)
    {
        $user1 = auth()->user();
        $user2 = DB::table('users')->where('id', $id)->first();
        
        if (!$user2) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if a chat room exists between the two users
        $chatRoom = ChatRoom::where(function ($query) use ($user1, $user2) {
            $query->where('user1_id', $user1->id)
                ->where('user2_id', $user2->id);
        })->orWhere(function ($query) use ($user1, $user2) {
            $query->where('user1_id', $user2->id)
                ->where('user2_id', $user1->id);
        })->first();

        if (!$chatRoom) {
            // Create a new chat room
            $chatRoom = ChatRoom::create([
                'user1_id' => $user1->id, // Use the `id` attribute here
                'user2_id' => $user2->id, // Use the `id` attribute here
            ]);
            
        }
        $messages = DB::table("messages")->where('chat_room_id', $chatRoom->id)->get();
        return view("chatroom", compact('chatRoom','messages','id','user1'));

        // return response()->json($chatRoom);
    }
    

    public function sendMessage(Request $request)
    {
        $user = auth()->user();
        $message = Message::create([
            'chat_room_id' => $request->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message'=>$request->message,
        ]);
    }

    public function getMessages($chatRoomId)
    {
        $messages = Message::where('chat_room_id', $chatRoomId)->get();
        return response()->json($messages);
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
