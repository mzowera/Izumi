<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'contact_number', 
        'email',
        'address'
    ];

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'student_guardian', 'student_id', 'guardian_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course', 'student_id', 'course_id');
    }

}
