<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function getData()
    {
        $question = Question::with('answer')->get();
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

    public function DashboardQuickInfo()
    {
        $question = Question::count();
        $physics = Question::where('subject', 'Physics')->count();
        $chemistry = Question::where('subject', 'Chemistry')->count();
        $student = Student::count();

        if($question) {
            return response()->json([
                'status' => 200,
                'question' => $question,
                'physics' => $physics,
                'chemistry' => $chemistry,
                'student' => $student
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

            $question = Question::create([
                'question' => $request->question,
                'subject' => $request->subject,
                'status' => $request->status,
                'expiry_date' => $request->expiry_date
            ]);

            if($question) {
                Answer::create([
                    'question_id' => $question->id,
                    'option1' => $request->option1,
                    'option2' => $request->option2,
                    'option3' => $request->option3,
                    'option4' => $request->option4,
                    'correct' => $request->correct
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Question Added Successully!!!'
                ]);
            }


        } catch(ValidationException $e) {
            return response()->json([
                'status' => 404,
                'errors' => $e->validator->getMessageBag()->toArray()
            ]);
        }
    }
}
