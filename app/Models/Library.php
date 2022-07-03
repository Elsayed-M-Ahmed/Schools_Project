<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $guarded = [] ;

    public function teacher() {
        return $this->belongsTo(Teacher::class , 'teacher_id');
    }

    public function grade() {
        return $this->belongsTo(Grade::class , 'Grade_id');
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class , 'Classroom_id');
    }

    public function section() {
        return $this->belongsTo(Section::class , 'section_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class , 'subject_id');
    }
}
