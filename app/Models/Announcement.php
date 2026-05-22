<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'user_id',
        'target_role',
        'published_at',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
