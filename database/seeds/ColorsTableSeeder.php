<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['red', 'green', 'blue'] as $color) {
            DB::table('colors')->insert([
                'code' => $color
            ]);
        }
    }
}
