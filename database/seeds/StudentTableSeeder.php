<?php

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Parents;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Blood_type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        $students = new Student();
        $students->name = ['ar' => 'احمد السيد', 'en' => 'Ahmed elsayed'];
        $students->email = 'Ahmed_Ibrahim@yahoo.com';
        $students->password = Hash::make('12345678');
        $students->gender_id = 1;
        $students->nationalitie_id = Nationalitie::all()->unique()->random()->id;
        $students->blood_id =Blood_type::all()->unique()->random()->id;
        $students->Date_Birth = date('1995-01-01');
        $students->Grade_id = 1;
        $students->Classroom_id =1;
        $students->section_id = 1;
        $students->parent_id = Parents::all()->unique()->random()->id;
        $students->academic_year ='2021';
        $students->save();
    }
}
