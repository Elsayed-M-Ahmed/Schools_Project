<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model 
{

    use HasTranslations;
    public $translatable = ['classroom_name'];
    protected $table = 'classrooms';
    public $timestamps = true;
    protected $fillable=['classroom_name','Grade_id'];

    public function Grades()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }

}