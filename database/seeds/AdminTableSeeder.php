<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('email' , '=' , 'elsaud93@gmail.com')->get();

        if ($user) {
            DB::table('users')->where('email' , '=' , 'elsaud93@gmail.com')->delete();

            User::create(['email' => 'elsaud93@gmail.com' , 'password' => Hash::make('11111111') , 'name' => 'elsayed']);
        }else{
        
            User::create(['email' => 'elsaud93@gmail.com' , 'password' => Hash::make('11111111') ,  'name' => 'elsayed']);
        
        }
    }
}
