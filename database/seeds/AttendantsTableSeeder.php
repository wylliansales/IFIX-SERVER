<?php

use Illuminate\Database\Seeder;

class AttendantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Attendant::class, 100)->create();
    }
}
