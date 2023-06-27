<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;

class ChatController extends Controller
{
    use HttpResponses;
    
    public function index()
    {
        return MessageResource::collection(
            Message::where('message_from', Auth::user()->id)->get()
        );  
    }

    
    public function create()
    {
        //
    }

    
    public function store(MessageRequest $request)
    {
        $request->validated($request->all());

        $message = Message::create([
            'message' => $request->message,
            'message_from' => Auth::user()->id,
            'message_to' => intval($request->message_to)
        ]);

        return $this->success([
            '',
            'message' => "sent"
        ]);

    }

    
    public function show($id)
    {
        return MessageResource::collection(
            Message::where(function ($query) use ($id) {
                $query->where(function ($query) use ($id) {
                    $query->where('message_from', Auth::user()->id)
                        ->where('message_to', $id);
                })->orWhere(function ($query) use ($id) {
                    $query->where('message_from', $id)
                        ->where('message_to', Auth::user()->id);
                });
            })->get()
        ); 
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
