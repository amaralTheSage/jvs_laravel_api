<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $authenticated = Auth::attempt(['name' => $request['name'], 'password' => $request['password']]);

        if ($authenticated) {
            $user = Auth::user();

            // This method is given to User by the hasApiTokens trait
            $adminToken = $user->createToken('admin_token', ['create', 'update', 'delete']);

            return ['admin_token' => $adminToken->plainTextToken];
        }

        return response('Wrong username or password');
    }
}
