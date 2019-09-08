<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;

class PollsController extends Controller
{
    public function index()
    {
        return response()->json(Poll::all(), 200);
    }

    public function show($id)
    {
        return response()->json(Poll::find($id), 200);
    }

    public function store(Request $request)
    {
        $poll = Poll::create($request->post());
        return response()->json($poll, 201);
    }
}
