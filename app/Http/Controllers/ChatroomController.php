<?php

namespace App\Http\Controllers;

use App\Events\RoomEvent;
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
        $join = RoomMembers::where('user_id', $user->id)->where('room_id', $room->id)->exists();
        if (!$join)
        {
            $room->members()->create([
                'user_id' => $user->id,
            ]);
        }

        return view('chatroom.message', compact('room'));
    }
}
