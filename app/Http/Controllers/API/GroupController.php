<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groupIdList = Group::where('convo_id', $id)->pluck('group_id');

        $groupMembers = GroupMember::whereIn('group_id', $groupIdList)
                                    ->where('user_id', '!=', auth()->user()->user_id)
                                    ->get();

        if ($groupMembers->isEmpty()) {
            return response()->json(['error' => 'No Members'], 404);
        }
    
        return response()->json(['members' => $groupMembers], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
