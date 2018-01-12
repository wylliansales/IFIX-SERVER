<?php

use Illuminate\Database\Seeder;

class RequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Request::class,10)->create()->each(function ($r){
            $r->equipaments()->save(factory(App\Models\Equipment::class)->make());
            $r->status()->save(factory(App\Models\Status::class)->make());
        });
    }
}
