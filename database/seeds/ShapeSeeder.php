<?php

use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->get();

        foreach ($users as $user) {
            $user->circles()->saveMany(
                factory(Circle::class, rand(1, 10))->make()
            );

            $user->rectangles()->saveMany(
                factory(Rectangle::class, rand(1, 10))->make()
            );
        }
    }
}
