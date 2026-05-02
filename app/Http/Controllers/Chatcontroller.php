<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ChatAgent;
use Illuminate\Http\Request;

class Chatcontroller extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $response = (new ChatAgent)
            ->prompt($request->message);

        return response()->json([
            'status' => 'success',
            'message' => (string) $response,
        ]);
    }
}
