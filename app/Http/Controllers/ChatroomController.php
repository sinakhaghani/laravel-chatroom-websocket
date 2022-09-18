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

    /**
     * display room view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rooms = Room::with('user')->latest()->get();

        return view('chatroom.room', compact('rooms'));
    }

    /**
     * create room and broadcast
     * @param Request $request
     * title(string): Title of the room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createRoom(Request $request)
    {
        $room = auth()->user()->rooms()->create([
            'title' => $request->input('title'),
        ]);
        auth()->user()->members()->create([
            'room_id' => $room->id,
        ]);
        alert()->success('create room success');
        broadcast(new RoomEvent($room))->toOthers();
        return redirect()->route('room.view');
    }

    /**
     * display message view and add user to room
     * @param Room $room
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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
            alert()->success('You have joined the group');
        }
        broadcast(new MemberEvent($room->id))->toOthers();
        return view('chatroom.message', compact('room', 'messages'));
    }

    /**
     * create message and broadcast
     * @param Request $request
     * message(string): message of user
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     */
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
