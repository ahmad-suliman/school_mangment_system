<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'class_name',
        'section',
        'academic_year',
    ];
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function classSubjectTeachers(){
        $this->hasMany(Class_subject_teacher::class,'class_id');
    }
}
