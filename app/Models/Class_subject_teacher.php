<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Class_subject_teacher extends Model
{
   protected $fillable =[
    'class_id',
    'subject_id',
    'teacher_id',
    'academic_year',
   ];

   public function classroom(){
        return $this->belongsTo(Classes::class,'class_id');
   }
   public function subject(){
        return  $this->belongsTo(Subject::class,'subject_id');
   }
   public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id');
   }
}
