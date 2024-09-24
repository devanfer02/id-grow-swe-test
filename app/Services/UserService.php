<?php

namespace App\Services;

use App\Models\User;
use App\Utils\HTTPResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:200',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:100'
        ]);

        if ($validator->fails())
        {
            return HTTPResponse::send('fail', 'failed to register user', 400, null, $validator->errors());
        }

        User::create($request->all());

        return HTTPResponse::send('success', 'successfully to register user', 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return HTTPResponse::send(
                'fail',
                'failed to login user',
                400,
                null,
                [
                    'credential' => 'invalid credentials'
                ]
            );
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return HTTPResponse::send(
            'success',
            'successfully login user',
            200,
            [
                'token' => $token
            ]
        );
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:200',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|string|min:8|max:100'
        ]);

        if ($validator->fails())
        {
            return HTTPResponse::send('fail', 'failed to update user', 400, null, $validator->errors());
        }



        $user->fill($request->only('email', 'name', 'password'))->save();

        return HTTPResponse::send('success', 'successfully update user', 200);
    }

    public function fetchUser(Request $request)
    {
        return HTTPResponse::send('success', 'successfully fetch user data', 200, $request->user());
    }
}
