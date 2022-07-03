<?php

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Grades = [
            [

                'en'=> 'primary',
                'ar'=> 'ابتدائى'
            ],[

                'en'=> 'middle',
                'ar'=> 'اعدادى'
            ],[

                'en'=> 'high',
                'ar'=> 'ثانوى'
            ]
        ];


        foreach ($Grades as $Grade) {
            Grade::create(['Name' => $Grade]);
        }
    }
}
