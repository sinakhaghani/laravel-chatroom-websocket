<?php

namespace App\Http\Controllers;

use App\Events\MemberEvent;
use App\Events\MessageEvent;
use App\Events\RoomEvent;
use App\Models\Message;
use App\Models\Room;
use App\Models\RoomMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use UxWeb\SweetAlert\SweetAlert;


class ChatroomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('user')->latest()->get();

        return view('chatroom.room', compact('rooms'));
    }

    public function createRoom(Request $request)
    {
        $room = auth()->user()->rooms()->create([
            'title' => $request->input('title'),
        ]);
        alert()->success('create room success');
        broadcast(new RoomEvent($room))->toOthers();
        return redirect()->route('room.view');
    }

    public function messageView(Room $room)
    {
        $user = auth()->user();
        $messages = Message::where('room_id', $room->id)->get();
        $join = RoomMembers::where('user_id', $user->id)->where('room_id', $room->id)->exists();
        if (!$join)
        {
            $room->members()->create([
                'user_id' => $user->id,
            ]);
        }
        broadcast(new MemberEvent($room->id))->toOthers();
        return view('chatroom.message', compact('room', 'messages'));
    }

    public function messageStore(Request $request, Room $room)
    {
        $user = auth()->user();
        $room->messages()->create([
            'user_id' => $user->id,
            'body' => $request->input('message'),
        ]);
        broadcast(new MessageEvent($room->id))->toOthers();
        return redirect()->route('room.message.view', $room);
    }
}
