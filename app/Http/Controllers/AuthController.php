<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(UserLoginRequest $request)
    {
        $request->validated($request->all());

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->error(null, 'Credentials does not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken("API token of {$user->name}")->plainTextToken,
        ]);
    }


    public function register(FormUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return $this->success([
            'user' => $user,
            'token' => $user->createToken("API token of {$user->name}")->plainTextToken,
        ]);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        // Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'You have successfully logged out');
    }
}
