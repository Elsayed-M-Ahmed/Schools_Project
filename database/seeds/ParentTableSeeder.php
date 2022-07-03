<?php

use App\Models\Parents;
use App\Models\Nationalitie;
use App\Models\Religion;
use App\Models\Blood_type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parents')->delete();
            $my_parents = new Parents();
            $my_parents->email = 'elsaud.gamal77@yahoo.com';
            $my_parents->password = Hash::make('12345678');
            $my_parents->Name_Father = ['en' => 'elsaudgamal', 'ar' => ' السيد'];
            $my_parents->National_ID_Father = '1234567810';
            $my_parents->Passport_ID_Father = '1234567810';
            $my_parents->Phone_Father = '1234567810';
            $my_parents->Job_Father = ['en' => 'programmer', 'ar' => 'مبرمج'];
            $my_parents->Nationality_Father_id = Nationalitie::all()->unique()->random()->id;
            $my_parents->Blood_Type_Father_id =Blood_type::all()->unique()->random()->id;
            $my_parents->Religion_Father_id = Religion::all()->unique()->random()->id;
            $my_parents->Address_Father ='القاهرة';
            $my_parents->Name_Mother = ['en' => 'SS', 'ar' => 'سس'];
            $my_parents->National_ID_Mother = '1234567810';
            $my_parents->Passport_ID_Mother = '1234567810';
            $my_parents->Phone_Mother = '1234567810';
            $my_parents->Job_Mother = ['en' => 'Teacher', 'ar' => 'معلمة'];
            $my_parents->Nationality_Mother_id = Nationalitie::all()->unique()->random()->id;
            $my_parents->Blood_Type_Mother_id =Blood_type::all()->unique()->random()->id;
            $my_parents->Religion_Mother_id = Religion::all()->unique()->random()->id;
            $my_parents->Address_Mother ='القاهرة';
            $my_parents->save();

    }
}
