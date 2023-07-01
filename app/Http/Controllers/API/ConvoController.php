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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
