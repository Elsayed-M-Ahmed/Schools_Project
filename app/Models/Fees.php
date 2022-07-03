<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fees extends Model
{
    protected $guarded =[];
    use HasTranslations;
    public $translatable = ['title'];

    public function grade()
    {
        return $this->belongsTo( Grade::class, 'Grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo( Classroom::class, 'Classroom_id');
    }
}
