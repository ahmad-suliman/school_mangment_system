<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'user_id',
        'student_id',
        'class_id',
        'phone',
        'birth_date',
        'address',
        'guardian_name',
        'guardian_phone',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function classroom(){
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function attendances()
    {
     return $this->hasMany(Attendance::class);
    }
    public function grades(){
        return $this->hasMany(Grade::class);
    }
}
