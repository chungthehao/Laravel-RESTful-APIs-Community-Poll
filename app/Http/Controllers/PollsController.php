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
        // * Tự custom sẽ trả về gì nếu ko tìm thấy
        $poll = Poll::find($id);
        if (is_null($poll)) return response()->json(null, 404);
        return response()->json($poll, 200);

        // * Trả về html 404
        //return response()->json(Poll::findOrFail($id), 200);

        // * Trả về {} 200 nếu ko tìm thấy -> chưa tốt
        //return response()->json(Poll::find($id), 200);
    }

    public function store(Request $request)
    {
        $poll = Poll::create($request->post());
        return response()->json($poll, 201);
    }

    public function update(Request $request, Poll $poll)
    {
        $poll->update($request->all());
        return response()->json($poll, 200);
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return response()->json(null, 204); // 204: no content (remove successfully)
    }
}
