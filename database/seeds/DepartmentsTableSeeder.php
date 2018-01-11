<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Department::class, 10)->create()->each(function ($d) {
            $d->attendants()->save(factory(App\Models\Attendant::class)->make());
        });
    }
}
