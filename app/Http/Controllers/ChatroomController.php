<?php

namespace App\Http\Controllers;

use App\Events\RoomEvent;
use App\Models\Room;
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
}
