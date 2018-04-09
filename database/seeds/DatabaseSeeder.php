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
         //$this->call(AttendantsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
         $this->call(EquipmentsTableSeeder::class);
         //$this->call(RequestsTableSeeder::class);

        DB::table('users')->insert([
            'name'     => 'Coordenador',
            'email'      => 'admin@admin.com',
            'password'   => bcrypt('123456'),
            'activated' => '1',
            'remember_token' => str_random(10),
        ]);
    }
}
