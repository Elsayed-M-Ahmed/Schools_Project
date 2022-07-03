<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;
    public $translatable = ['Name_Section'];
    protected $fillable=['Name_Section','Grade_id','Class_id'];

    protected $table = 'sections';
    public $timestamps = true;


    // علاقة بين الاقسام والصفوف لجلب اسم الصف في جدول الاقسام

    public function Classrooms()
    {
        return $this->belongsTo('App\Models\Classroom', 'Class_id');
    }

    public function Teachers() {
        return $this->belongsToMany('App\Models\Teacher' , 'teacher_section');
    }

    public function Grades() {
        return $this->belongsTo(Grade::class , 'Grade_id');
    }

}
