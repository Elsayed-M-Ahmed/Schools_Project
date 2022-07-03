<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GradesTableSeeder::class);
         $this->call(BloodtTableSeeder::class);
         $this->call(NationalitiesTableSeeder::class);
         $this->call(religionTableSeeder::class);
         $this->call(GenderTableSeeder::class);
         $this->call(SpecializationsTableSeeder::class);
         $this->call(AdminTableSeeder::class);
         $this->call(ClassroomsTableSeeder::class);
         $this->call(SectionsTableSeeder::class);
         $this->call(ParentsTableSeeder::class);
         $this->call(StudentTableSeeder::class);
         $this->call(SettingTableSeeder::class);
    }
}
