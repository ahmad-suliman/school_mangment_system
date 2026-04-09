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
    $this->hasMany(Class_subject_teacher::class,'teacher_id');
   }
}
