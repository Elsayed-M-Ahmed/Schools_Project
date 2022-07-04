<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

    // علاقة بين الطلاب والانواع لجلب اسم النوع في جدول الطلاب

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }
    
    // علاقة بين الطلاب والمراحل الدراسية لجلب اسم المرحلة في جدول الطلاب

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }


    // علاقة بين الطلاب الصفوف الدراسية لجلب اسم الصف في جدول الطلاب

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }

    // علاقة بين الطلاب الاقسام الدراسية لجلب اسم القسم  في جدول الطلاب

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
    
    // علاقه بين الطلاب و الصور لجلب الصور فى جدول الطلاب
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function Nationality() {
        return $this->belongsTo(Nationalitie::class , 'nationalitie_id');
    }

    public function student_parent() {
        return $this->belongsTo(Parents::class , 'parent_id');
    }

    public function student_account() {
        return $this->hasMany(StudentsAccounts::class , 'student_id');
    }
    
    public function attendance() {
        return $this->hasMany(Attendance::class , 'student_id');
    }
}
