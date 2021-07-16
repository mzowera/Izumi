<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Course;
use App\Guardian;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            'stats' => [
                [
                    'title' => 'Students',
                    'icon' => 'graduation-cap',
                    'link' => '/student/search',
                    'value' => Student::all()->count(),
                    'enabled' => true
                ],
                [
                    'title' => 'Courses',
                    'icon' => 'leanpub',
                    'link' => '/course/search',
                    'value' => Course::all()->count(),
                    'enabled' => true
                ],
                [
                    'title' => 'Guardians',
                    'icon' => 'user',
                    'link' => '/guardian/search',
                    'value' => Guardian::all()->count(),
                    'enabled' => true
                ],
            ]
        ]);
    }
}
