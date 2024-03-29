<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function getData()
    {
        $student = Student::all();
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student Not Found'
            ]);
        }

    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:students|email',
            ]);

            Student::create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Student Added Successully!!!'
            ]);
        } catch(ValidationException $e) {
            return response()->json([
                'status' => 404,
                'errors' => $e->validator->getMessageBag()->toArray()
            ]);
        }
    }
}
