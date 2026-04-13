<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_name',
        'subject_code',
    ];
    public function classSubjectTeachers(){
        return $this->hasMany(Class_subject_teacher::class,'subject_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'subject_id');
    }
    public function grades(){
        return $this->hasMany(Grade::class);
    }
}
