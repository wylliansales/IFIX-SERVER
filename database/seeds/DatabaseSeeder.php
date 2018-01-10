<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(AdministratorsTableSeeder::class);
         $this->call(SectorsTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(StatusTableSeeder::class);
         $this->call(AttendantsTableSeeder::class);
         $this->call(EquipmentsTableSeeder::class);
         $this->call(DepartmentsTableSeeder::class);
    }
}
