<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
   protected $fillable = [
    'user_id',
    'teacher_id',
    'phone',
    'specialization',
    'hire_date',
    'address',

   ];
   public function user(){
        return $this->belongsTo(User::class);
   }
   public function classSubjectTeachers(){
        return $this->hasMany(Class_subject_teacher::class,'teacher_id');
   }
   public function attendances(){
    return $this->hasMany(Attendance::class,'teacher_id');
   }
   public function grades(){
    return $this->hasMany(Grade::class);
   }
}
