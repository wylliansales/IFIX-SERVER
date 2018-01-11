<?php

use Illuminate\Database\Seeder;

class EquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Equipment::class, 100)->create()->each(function ($e){
            $e->requests()->save(factory(App\Models\Request::class)->make());
        });
    }
}
