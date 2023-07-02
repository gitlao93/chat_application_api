<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Convo;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Http\Response;

class ConvoController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of Conversations.
     */
    public function index()
    {
        $user_id = Auth::user()->user_id;
        $conversations = Convo::select('convos.convo_id', 'convos.convo_name')
            ->join('groups', 'convos.convo_id', '=', 'groups.convo_id')
            ->join('group_members', 'groups.group_id', '=', 'group_members.group_id')
            ->join('users', 'group_members.user_id', '=', 'users.user_id')
            ->where('users.user_id', '=', $user_id)
            ->get();
    
        return response()->json(['conversations' => $conversations], 200);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conversation = Convo::find($id);
        if (!$conversation) {
            // Conversation not found
            return $this->error(['message' => 'Convo not found'], 'Convo not found', 401);;
        }
        
        $conversation->convo_name = $request->convo_name;
        $conversation->update();
        
        // Conversation updated successfully
        return $this->success(['message' => 'Convo edites'], 'Message sent successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
