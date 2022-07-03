<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Classroom;

class ClassroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms_name_for_primary_Grade = [
            [
 
                'en'=> 'first',
                'ar'=> 'الاول'
            ] ,[

              
                'en'=> 'second',
                'ar'=> 'الثانى'
            ] ,[

               
                'en'=> 'third',
                'ar'=> 'الثالث'

            ] ,[

                
                'en'=> 'fourth',
                'ar'=> 'الرابع'
 
            ] ,[

        
                'en'=> 'fifth',
                'ar'=> 'الخامس'

            ] ,[

  
                'en'=> 'sixth',
                'ar'=> 'السادس'
            ]
        ];

        $classrooms_name_for_middle_and_high_Grade = [
            [
 
                'en'=> 'first',
                'ar'=> 'الاول'
            ] ,[

              
                'en'=> 'second',
                'ar'=> 'الثانى'
            ] ,[

               
                'en'=> 'third',
                'ar'=> 'الثالث'

            ] ,
            ];


        DB::table('classrooms')->delete();

        foreach ($classrooms_name_for_primary_Grade as $classroom_name) {
            Classroom::create([
                'classroom_name' => $classroom_name ,
                'Grade_id' => '1',
            ]);
        }

        foreach ($classrooms_name_for_middle_and_high_Grade as $classroom_name) {
            Classroom::create([
                'classroom_name' => $classroom_name ,
                'Grade_id' => '2',
            ]);
        }

        foreach ($classrooms_name_for_middle_and_high_Grade as $classroom_name) {
            Classroom::create([
                'classroom_name' => $classroom_name ,
                'Grade_id' => '3',
            ]);
        }
    }
}
