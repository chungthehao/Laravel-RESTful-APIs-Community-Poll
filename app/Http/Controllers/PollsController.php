<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Poll as PollResource;

class PollsController extends Controller
{
    public function index()
    {
        return response()->json(Poll::all(), 200);
    }

    public function show($id)
    {
        $poll = Poll::findOrFail($id);
        $response['poll'] = $poll;
        $response['questions'] = $poll->questions;
        return response()->json($response, 200);

        // * Tự custom sẽ trả về gì nếu ko tìm thấy
//        $poll = Poll::with('questions')->find($id);
//        if (is_null($poll)) return response()->json(null, 404);
//        $pollResource = new PollResource($poll);
//        return response()->json($pollResource, 200);

        // * Trả về html 404
        //return response()->json(Poll::findOrFail($id), 200);

        // * Trả về {} 200 nếu ko tìm thấy -> chưa tốt
        //return response()->json(Poll::find($id), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

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

    public function errors()
    {
        return response()->json([
            'errorMsg' => 'Payment is required.'
        ], 501); // Error code: Not Implemented
    }

    public function questions(Poll $poll)
    {
        return response()->json($poll->questions, 200);
    }
}
