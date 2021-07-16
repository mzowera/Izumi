<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Course;

class CourseController extends Controller
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

    public function search(Request $request)
    {
        return view('course.search', [
            'courses' => Course::all()
        ]);
    }
}
