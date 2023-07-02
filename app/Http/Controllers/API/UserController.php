<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use HttpResponses;
    /**
     * Display a users.
     */
    public function index()
    {
        $authenticatedUserId = Auth::id();

        $users = User::where('user_id', '!=', $authenticatedUserId)
            ->orderBy('name', 'asc')
            ->get();

        if ($users->isEmpty()) {
            return response()->json(['error' => 'No user'], 404);
        }
    
        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function searchUserByName(Request $request)
    {
        $user = User::where('name', 'LIKE', '%'.$request->name.'%')->get();

        if ($user->isEmpty()) {
            return response()->json(['error' => 'No user'], 404);
        }
    
        return response()->json(['users' => $user], 200);
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
