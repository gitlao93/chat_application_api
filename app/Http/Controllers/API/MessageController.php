<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Convo;
use App\Models\Group;
use App\Models\Message;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $senderId = Auth::user()->user_id;
        $receiverId = $id;
        $receiverName = User::where('user_id', $receiverId)->value('name');

        // Check if receiver and sender belong to the same group
        $group = Group::whereHas('members', function ($query) use ($senderId, $receiverId) {
            $query->where(function ($subQuery) use ($senderId, $receiverId) {
                $subQuery->where('user_id', $senderId)
                    ->orWhere('user_id', $receiverId);
            });
        })->first();

        if (!$group) {
            // Create a new group
            $group = new Group();
            $group->convo_id = $this->createConvo($receiverName);
            $group->group_name = $receiverName;
            $group->save();
            // Add sender and receiver to the group members
            $this->addMemberToGroup($group->group_id, $senderId);
            $this->addMemberToGroup($group->group_id, $receiverId);
        }

        // Create and save the message
        $message = new Message();
        $message->convo_id = $group->convo_id;
        $message->sender_id = $senderId;
        $message->content = $request->content;
        $message->save();

        if (!$message) {
            return $this->error([], 'Failed to save the message.', 500);
        }
    
        return $this->success(['message' => 'Message sent successfully'], 'Message sent successfully', 200);
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


    private function createConvo($receiverName)
    {
        $convo = new Convo();
        $convo->convo_name = $receiverName;
        $convo->save();

        return $convo->convo_id;
    }

    private function addMemberToGroup($groupId, $userId)
    {
        $member = new GroupMember();
        $member->group_id = $groupId;
        $member->user_id = $userId;
        $member->save();
    }
}
