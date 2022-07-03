<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded=[];

        // علاقة بين المعلمين والتخصصات لجلب اسم التخصص
        public function specializations()
        {
            return $this->belongsTo(specialization::class, 'Specialization_id');
        }
    
        // علاقة بين المعلمين والانواع لجلب جنس المعلم
        public function genders()
        {
            return $this->belongsTo(Gender::class, 'Gender_id');
        }

        // علاقه المعلمين مع الاقسام
        public function Sections() {
            return $this->belongsToMany(Section::class , 'teacher_section');
        }
    
}
