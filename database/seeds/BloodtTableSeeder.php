<?php

use Illuminate\Database\Seeder;
use App\Models\Blood_type;
use Illuminate\Support\Facades\DB;

class BloodtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Blood_types')->delete();

        $blood_types = ['O-' , '0+' , 'A-' , 'A+' , 'B-' , 'B+' , 'AB-' , 'AB+'];

        foreach ($blood_types as $blood_type) {
            Blood_type::create(['Name' => $blood_type]);
        }
    }
}
