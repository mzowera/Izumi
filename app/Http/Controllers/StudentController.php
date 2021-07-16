<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Course;
use App\Student;
use App\Guardian;
use App\Rules\ExistingEmailValidation;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $student = new Student;

        if ($request->isMethod('post'))
        {
            $validated = $request->validate([
                'name' => 'required',
                'contact_number' => 'required',
                'email' => 'required|unique:students|max:255',
                'address' => 'required'
            ]);

            if ( $validated )
            {
                $student->name = $request->name;
                $student->contact_number = $request->contact_number;
                $student->email = $request->email;
                $student->address = $request->address;
                $student->save();

                $student->courses()->attach($request->courses);
                $student->guardians()->attach($request->guardians);

                return redirect('/student/edit/'.$student->id);
            }
        }

        return view('student.create',
            [
                'courses' => Course::all(),
                'guardians' => Guardian::all(),
                'request' => $request->all()
            ]
        );
    }

    public function edit(Request $request, $id)
    {
        $student = Student::find($id);
        $saved = false;

        if ( !$student )
        {
            return abort(404);
        }

        if ($request->isMethod('post'))
        {
            // if delete
            if ( $request->submit == "delete" )
            {
                $student->delete();
                return redirect("/student/search");
            }

            //else
            $validated = $request->validate([
                'name' => 'required',
                'contact_number' => 'required',
                'email' => new ExistingEmailValidation($student->email, 'students'),
                'address' => 'required'
            ]);

            if ( $validated )
            {
                $student->name = $request->name;
                $student->contact_number = $request->contact_number;
                $student->email = $request->email;
                $student->address = $request->address;
                $student->save();

                $student->courses()->detach();
                $student->courses()->attach($request->courses);
                $student->guardians()->detach();
                $student->guardians()->attach($request->guardians);

                $saved = true;
            }
        }
        
        $student_courses = DB::table('student_course')
            ->where( 'student_id', '=', $id)
            ->select('course_id')
            ->distinct()
            ->get()
            ->map(function($value){
                return $value->course_id;
            });

        $student_guardians = DB::table('student_guardian')
            ->where( 'student_id', '=', $id)
            ->select('guardian_id')
            ->distinct()
            ->get()
            ->map(function($value){
                return $value->guardian_id;
            });

        return view('student.edit',
            [
                'student' => $student,
                'student_courses' => $student_courses,
                'student_guardians' => $student_guardians,
                'saved' => $saved,
                'courses' => Course::all(),
                'guardians' => Guardian::all(),
                'request' => $request->all()
            ]
        );
    }

    public function search(Request $request)
    {
        return view('student.search', [
            'students' => Student::all()
        ]);
    }
}
