<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeInvoices extends Model
{
    protected $guarded =[];

    public function student() {
       return $this->belongsTo(Student::class , 'student_id');
    }

    public function fees() {
        return $this->belongsTo(Fees::class , 'fee_id'); 
    }

    public function grade() {
        return $this->belongsTo(Grade::class , 'Grade_id'); 
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class , 'Classroom_id'); 
    }
}
