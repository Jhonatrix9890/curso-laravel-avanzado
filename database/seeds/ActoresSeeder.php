<?php

use Illuminate\Database\Seeder;

class ActoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Actor::Class, 30)->create();
    }
}
