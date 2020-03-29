<?php


namespace App\Http\Services;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AuthService
{
    /**
     * @param User        $user
     * @param FormRequest $request
     */
    public static function checkToken(User $user, FormRequest $request)
    {
        if (!$request->has('api_token')) {
            abort(401, 'No API Token provided.');
        }

        if ($user->api_token !== $request->get('api_token')) {
            abort(401, 'Bad API Token.');
        }
    }
}
