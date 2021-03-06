<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class online_class extends Model
{
    protected $guarded = [];

    public function grade() {
        return $this->belongsTo(Grade::class , 'Grade_id');
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class , 'Classroom_id');
    }

    public function section() {
        return $this->belongsTo(Section::class , 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
