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
        
    }

    /**
     * Store message.
     */
    public function store(Request $request, $id)
    {
        $senderId = Auth::user()->user_id;
        $senderName = Auth::user()->name;
        $receiverId = $id;
        $receiverName = User::where('user_id', $receiverId)->value('name');
        
        $group = Group::join('group_members as member1', 'member1.group_id', '=', 'groups.group_id')
                ->join('group_members as member2', 'member2.group_id', '=', 'groups.group_id')
                ->where('member1.user_id', $senderId)
                ->where('member2.user_id', $receiverId)
                ->select('groups.*')
                ->first();

        

        if (!$group) {
            // Create a new group
            $group = Group::create([
                'group_name' => $receiverName,
                'convo_id' => $this->createConvo($receiverName,$senderName)
            ]);
            
            // Add sender and receiver to the group members
            $this->addMemberToGroup($group->group_id, $senderId);
            $this->addMemberToGroup($group->group_id, $receiverId);
        }

        // Create and save the message
        $message = Message::create([
            'sender_id' => $senderId,
            'content' => $request->content,
            'convo_id' => $group->convo_id
        ]);

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
    // show messages in a convo
    public function conversation($id)
    {
        $messages = Message::where('convo_id', $id)->get();

        if ($messages->isEmpty()) {
            return response()->json(['error' => 'No messages found for the given conversation ID'], 404);
        }
    
        return response()->json(['messages' => $messages], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    //create convo
    private function createConvo($receiverName,$senderName)
    {
        $convoName = $senderName . '\'s and ' . $receiverName . '\'s Convo';
        $convo = Convo::create([
            'convo_name' => $convoName
        ]);

        return $convo->convo_id;
    }
    // create convo
    private function addMemberToGroup($groupId, $userId)
    {
        $member = new GroupMember();
        $member->group_id = $groupId;
        $member->user_id = $userId;
        $member->save();
    }
}
