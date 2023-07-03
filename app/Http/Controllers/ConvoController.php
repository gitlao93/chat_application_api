<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ConvoResource;

class ConvoController extends Controller
{

    public function index() {

        $authenticatedUserId = auth()->user()->id;

        return ConvoResource::collection(
            User::whereIn('id', function ($query) {
                $query->select('message_from')
                    ->from('messages')
                    ->where('message_to', Auth::user()->id);
            })->get()
        );
    }
}
