<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatroomController extends Controller
{
    public function index()
    {
        return view('chatroom.room');
    }
}
