@extends('layouts.app')
@section('content')

    @include('sweet::alert')
<div class="container mx-auto">
    <div class="min-w-full border rounded lg:grid lg:grid-cols-3">
        <div class="border-r border-gray-300 lg:col-span-1">
            <div class="mx-3 my-3">
                <div class="relative text-gray-600">
              <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </span>
                    <input type="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none" name="search"
                           placeholder="Search" required />
                </div>
            </div>

            <ul class="overflow-auto h-[32rem]">
                <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Chats</h2>
                <li id="list-chatroom">
                    @foreach($rooms as $room)
                    <a
                        href="{{$room['path']}}"
                        class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
                        <img class="object-cover w-10 h-10 rounded-full"
                             src="{{asset('img/icon.png')}}" alt="username" />
                        <div class="w-full pb-2">
                            <div class="flex justify-between">
                                <span class="block ml-2 font-semibold text-gray-600">{{$room['title']}}</span>
                                <span class="block ml-2 text-sm text-gray-600">{{ $room['timeAgo'] }}</span>
                            </div>
                            <span class="block ml-2 text-sm text-gray-600">{{$room['user']['name']}}</span>
                        </div>
                    </a>
                    @endforeach
                </li>
            </ul>
        </div>
        <div class="hidden lg:col-span-2 lg:block">
            <div class="w-full">
                <div class="relative flex items-center p-3 border-b border-gray-300">
                    <span class="block ml-2 font-bold text-gray-600">Create Room</span>
              </span>
                </div>
                <div class="relative w-full p-6 overflow-y-auto h-[40rem]">
                    <div class="p-6">
                        <form method="post" action="{{ route('room.store')}}">
                            @csrf
                            <div>
                                Create Your Chat Room :
                                <input type="text" name="title" placeholder="chat room name" class="rounded-md p-2 shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <button type="submit" class="inline-flex items-center p-3 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    /*
    * Listen to the broadcast room and update the list
    */
    $(document).ready(function (){

        Echo.join(`room`)
            .here((data) => {

            })
            .joining((data) => {
                let list = '';
                $("#list-chatroom").empty();
                data.rooms.forEach(function(item) {
                    list += `
                        <a
                    href="`+ item.path +`"
                    class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
                    <img class="object-cover w-10 h-10 rounded-full"
                         src="{{asset('img/icon.png')}}" alt="username" />
                    <div class="w-full pb-2">
                        <div class="flex justify-between">
                            <span class="block ml-2 font-semibold text-gray-600">`+ item.title +`</span>
                            <span class="block ml-2 text-sm text-gray-600">`+ item.timeAgo +`</span>
                        </div>
                        <span class="block ml-2 text-sm text-gray-600">`+ item.user.name +`</span>
                    </div>
                </a>
                    `;
                });
                $("#list-chatroom").append(list);
            })
    });

    </script>

@endsection
