<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\DB;

class Parents extends Model
{
    use HasTranslations;
    public $translatable = ['Name_Father','Job_Father','Name_Mother','Job_Mother'];
    protected $table = 'parents';
    protected $guarded=[];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
