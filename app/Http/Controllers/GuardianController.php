<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Student;
use App\Guardian;
use App\Rules\ExistingEmailValidation;

class GuardianController extends Controller
{
    public function search(Request $request)
    {
        return view('guardian.search', [
            'guardians' => Guardian::all()
        ]);
    }

    public function create(Request $request)
    {
        $guardian = new Guardian;

        if ($request->isMethod('post'))
        {
            $validated = $request->validate([
                'name' => 'required',
                'contact_number' => 'required',
                'email' => 'required|unique:guardians|max:255',
            ]);

            if ( $validated )
            {
                $guardian->name = $request->name;
                $guardian->contact_number = $request->contact_number;
                $guardian->email = $request->email;
                $guardian->save();

                $guardian->students()->attach($request->students);

                return redirect('/guardian/edit/'.$guardian->id);
            }
        }

        return view('guardian.create',
            [
                'students' => Student::all(),
                'request' => $request->all()
            ]
        );
    }

    public function edit(Request $request, $id)
    {
        $guardian = Guardian::find($id);
        $saved = false;

        if ( !$guardian )
        {
            return abort(404);
        }

        if ($request->isMethod('post'))
        {
            // if delete
            if ( $request->submit == "delete" )
            {
                $guardian->delete();
                return redirect("/guardian/search");
            }

            //else
            $validated = $request->validate([
                'name' => 'required',
                'contact_number' => 'required',
                'email' => new ExistingEmailValidation($guardian->email, 'guardians'),
            ]);

            if ( $validated )
            {
                $guardian->name = $request->name;
                $guardian->contact_number = $request->contact_number;
                $guardian->email = $request->email;
                $guardian->save();

                $guardian->students()->detach();
                $guardian->students()->attach($request->students);

                $saved = true;
            }
        }

        $guardian_students = DB::table('student_guardian')
            ->where( 'guardian_id', '=', $id)
            ->select('student_id')
            ->distinct()
            ->get()
            ->map(function($value){
                return $value->student_id;
            });

        return view('guardian.edit',
            [
                'guardian' => $guardian,
                'guardian_students' => $guardian_students,
                'saved' => $saved,
                'students' => Student::all(),
                'request' => $request->all()
            ]
        );
    }
}
