<?php

namespace App\Http\Controllers;

use App\Http\Services\ShapeService;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return Factory|View
     */
    public function __invoke()
    {
        return view('welcome');
    }
}
