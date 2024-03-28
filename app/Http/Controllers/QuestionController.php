<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function getData()
    {
        $question = Question::where('status', 1)->get();
        if($question) {
            return response()->json([
                'status' => 200,
                'question' => $question
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Question Not Found'
            ]);
        }

    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'question' => 'required|unique:questions',
                'subject' => 'required',
                'status' => 'required',
                'expiry_date' => 'required',
            ]);

            Question::create([
                'question' => $request->question,
                'subject' => $request->subject,
                'status' => $request->status,
                'expiry_date' => $request->expiry_date
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Question Added Successully!!!'
            ]);
        } catch(ValidationException $e) {
            return response()->json([
                'status' => 404,
                'errors' => $e->validator->getMessageBag()->toArray()
            ]);
        }
    }
}
