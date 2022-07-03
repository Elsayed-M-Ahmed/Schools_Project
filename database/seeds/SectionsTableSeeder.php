<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Models\Grade;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections_name_for_primary_Grade = [
            [
 
                'en'=> 'A',
                'ar'=> 'أ'
            ] ,[

              
                'en'=> 'B',
                'ar'=> 'ب'
            ] ,[

               
                'en'=> 'C',
                'ar'=> 'ج'

            ] ,
            ];

            

            DB::table('sections')->delete();

            foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {

                $primary_class_ids = ['1' , '2' ,'3' , '4' , '5' , '6'];
                foreach ($primary_class_ids as $class_id ) {
                    Section::create([
                        'Name_Section' => $section_name_for_primary_Grade ,
                        'Status' => 1 ,
                        'Grade_id' => 1 ,
                        'Class_id' => $class_id ,
                    ]);
                }
                }
    
    
                foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
    
                    
                    $middle_school_class_ids = ['7' , '8' ,'9' ];
                   
                    foreach ($middle_school_class_ids as $class_id ) {
                        Section::create([
                            'Name_Section' => $section_name_for_primary_Grade ,
                            'Status' => 1 ,
                            'Grade_id' => 2 ,
                            'Class_id' => $class_id ,
                        ]);
                    }
                    }
    
                foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
                    $high_school_class_ids = ['10' , '11' ,'12'];
                    foreach ($high_school_class_ids as $class_id ) {
                        Section::create([
                            'Name_Section' => $section_name_for_primary_Grade ,
                            'Status' => 1 ,
                            'Grade_id' => 3 ,
                            'Class_id' => $class_id ,
                        ]);
                    }
                    }   
            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 1 ,
            //     ]);
            // }

            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 2 ,
            //     ]);
            // }

            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 3 ,
            //     ]);
            // }

            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 4 ,
            //     ]);
            // }

            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 5,
            //     ]);
            // }

            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {
            //     Section::create([
            //         'Name_Section' => $section_name_for_primary_Grade ,
            //         'Status' => 1 ,
            //         'Grade_id' => 1 ,
            //         'Class_id' => 6 ,
            //     ]);
            // }
/////////////////////
            // foreach ($sections_name_for_primary_Grade as $section_name_for_primary_Grade) {

            //     $Section_id =  Section::all();
            //     if ($Section_id->Grade_id = 1) {
            //     $primary_class_ids = ['1' , '2' ,'3' , '4' , '5' , '6'];
            //     }elseif ($Section_id->Grade_id = 2) {
            //         $primary_class_ids = ['7' , '8' ,'9' ];
            //     }elseif ($Section_id->Grade_id = 3) {
            //         $primary_class_ids = ['10' , '11' ,'12' ];
            //     }
            //     foreach ($primary_class_ids as $class_id ) {
            //         $Grade_ids = ['1' , '2' , '3'];
            //         foreach ($Grade_ids as $Grade_id) {
                    
            //         Section::create([
            //             'Name_Section' => $section_name_for_primary_Grade ,
            //             'Status' => 1 ,
            //             'Grade_id' => $Grade_id ,
            //             'Class_id' => $class_id ,
            //         ]);
    
            //     }
            //     }
            //     }
///////////////
             
///////////////////////////////////

                
            


            // $class_ids = ['1' , '2' ,'3'];
            // foreach ($class_ids as $class_id ) {
            //     Section::where('id' , '<' , '4' )->update([
            //         'Class_id' => $class_id,
            //     ]);
            // }
            
    }
}
