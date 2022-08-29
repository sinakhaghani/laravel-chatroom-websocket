<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use UxWeb\SweetAlert\SweetAlert;


class ChatroomController extends Controller
{

    public function index()
    {
        return view('chatroom.room');
    }

    public function createRoom(Request $request)
    {
        auth()->user()->rooms()->create([
            'title' => $request->input('title'),
        ]);
        alert()->success('create room success');
        return redirect()->route('room.view');
    }
}
