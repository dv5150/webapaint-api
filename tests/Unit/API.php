<?php

namespace Tests\Unit;

use App\Models\Color;
use App\Models\Shapes\Circle;
use App\Models\Shapes\Rectangle;
use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class API extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        $this->_prepareForTests();
    }


    private function _prepareForTests(): void
    {
        DB::table('colors')->insert([
            ['code' => 'red'],
            ['code' => 'green'],
            ['code' => 'blue'],
        ]);

        $users = factory(User::class, 3)->create();

        $users->each(function (User $user) {
            $user->circles()->saveMany(
                factory(Circle::class, 3)->make()
            );

            $user->rectangles()->saveMany(
                factory(Rectangle::class, 3)->make()
            );

            $user->worksheets()->saveMany(
                factory(Worksheet::class, 3)->make()
            );
        });

        $worksheets = Worksheet::query()
                               ->with('user.circles', 'user.rectangles')
                               ->get();

        $worksheets->each(function (Worksheet $worksheet) {
            $user = $worksheet->user;

            $user->circles->each(function(Circle $circle) use ($worksheet) {
                $worksheet->circles()->attach(
                    $circle->id,
                    [
                        'x' => (float) rand(-20, 120),
                        'y' => (float) rand(-20, 120)
                    ]
                );
            });

            $user->rectangles->each(function(Rectangle $rectangle) use ($worksheet) {
                $worksheet->rectangles()->attach(
                    $rectangle->id,
                    [
                        'x' => (float) rand(-20, 120),
                        'y' => (float) rand(-20, 120)
                    ]
                );
            });
        });
    }


    public function test_it_can_list_shapes_that_belong_to_a_user()
    {
        $response = $this->get(route('users.shapes.index', [
            'user' => User::query()->inRandomOrder()->first(),
        ]));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'shape_type',
                             'color_code'
                         ]
                     ]
                 ]);
    }


    public function test_it_can_show_details_of_a_circle_that_belongs_to_a_user()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $circle = $user->circles()
                       ->inRandomOrder()
                       ->first();

        $response = $this->get(route('users.shapes.show', [
            'user' => $user,
            'type' => $circle->shape_type,
            'shape' => $circle->id
        ]));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data'  => [
                         'id',
                         'radius',
                         'shape_type',
                         'color_code'
                     ]
                 ]);
    }


    public function test_it_can_show_details_of_a_rectangle_that_belongs_to_a_user()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $rectangle = $user->rectangles()
                          ->inRandomOrder()
                          ->first();

        $response = $this->get(route('users.shapes.show', [
            'user' => $user,
            'type' => $rectangle->shape_type,
            'shape' => $rectangle->id
        ]));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data'  => [
                         'id',
                         'width',
                         'height',
                         'shape_type',
                         'color_code'
                     ]
                 ]);
    }


    public function test_it_can_save_a_circle_to_a_user()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $response = $this->post(route('users.shapes.store', [
            'user' => $user
        ]), [
            'type' => 'circle',
            'color_id' => Color::query()
                               ->inRandomOrder()
                               ->first()->id,
            'radius' => (float) rand(5, 75),
            'api_token' => $user->api_token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'radius',
                         'shape_type',
                         'color_code',
                     ]
                 ]);
    }


    public function test_it_can_save_a_rectangle_to_a_user()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $response = $this->post(route('users.shapes.store', [
            'user' => $user
        ]), [
            'type' => 'rectangle',
            'color_id' => Color::query()
                               ->inRandomOrder()
                               ->first()->id,
            'width' => (float) rand(25, 150),
            'height' => (float) rand(25, 150),
            'api_token' => $user->api_token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'width',
                         'height',
                         'shape_type',
                         'color_code',
                     ]
                 ]);
    }


    public function test_it_can_list_worksheets_that_belong_to_a_user()
    {
        $response = $this->get(route('users.worksheets.index', [
            'user' => User::query()->inRandomOrder()->first(),
        ]));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                            'id',
                            'title',
                            'created_at',
                            'shapes' => [
                                '*' => [
                                    'id',
                                    'shape_type',
                                    'color_code'
                                ]
                            ]
                         ]
                     ]
                 ]);
    }


    public function test_it_can_store_a_worksheet_for_a_user()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $response = $this->post(route('users.worksheets.store', [
            'user' => $user
        ]), [
            'title' => 'ravenous wattle gobbler',
            'api_token' => $user->api_token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'title',
                         'created_at',
                         'shapes' => [
                             '*' => [
                                 'id',
                                 'shape_type',
                                 'color_code'
                             ]
                         ]
                     ]
                 ]);
    }


    public function test_it_can_attach_a_circle_to_a_worksheet()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $worksheet = $user->worksheets()
                          ->inRandomOrder()
                          ->first();

        $circle = $user->circles()
                       ->inRandomOrder()
                       ->first();

        $response = $this->post(route('users.worksheets.shapes.store', [
            'user' => $user,
            'worksheet' => $worksheet
        ]), [
            'id' => $circle->id,
            'type' => 'circle',
            'x' => (float) rand(-20, 120),
            'y' => (float) rand(-20, 120),
            'api_token' => $user->api_token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'headers',
                     'original' => [
                         'worksheet_id',
                         'shapelike_type',
                         'shapelike_id',
                         'x',
                         'y',
                         'created_at',
                         'updated_at'
                     ],
                     'exception'
                 ]);
    }


    public function test_it_can_attach_a_rectangle_to_a_worksheet()
    {
        $user = User::query()
                    ->inRandomOrder()
                    ->first();

        $worksheet = $user->worksheets()
                          ->inRandomOrder()
                          ->first();

        $rectangle = $user->rectangles()
                          ->inRandomOrder()
                          ->first();

        $response = $this->post(route('users.worksheets.shapes.store', [
            'user' => $user,
            'worksheet' => $worksheet
        ]), [
            'id' => $rectangle->id,
            'type' => 'rectangle',
            'x' => (float) rand(-20, 120),
            'y' => (float) rand(-20, 120),
            'api_token' => $user->api_token
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'headers',
                     'original' => [
                         'worksheet_id',
                         'shapelike_type',
                         'shapelike_id',
                         'x',
                         'y',
                         'created_at',
                         'updated_at'
                     ],
                     'exception'
                 ]);
    }
}
