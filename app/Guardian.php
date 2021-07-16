<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table = 'guardians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'contact_number', 
        'email'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_guardian', 'guardian_id', 'student_id');
    }

}
