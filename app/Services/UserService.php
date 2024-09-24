<?php

namespace App\Services;

use App\Models\User;
use App\Utils\HTTPResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function register(Request $request)
    {
        try {
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

        } catch (Exception $e) {
            error_log("[USER Service][login] error: " . $e->getMessage());
            return HTTPResponse::send('error', 'failed to register', 500);
        }
    }

    public function login(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            error_log("[USER Service][login] error: " . $e->getMessage());
            return HTTPResponse::send('error', 'failed to login', 500);
        }
    }

    public function update(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            error_log("[USER Service][update] error: " . $e->getMessage());
            return HTTPResponse::send('error', 'failed to update user', 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = $request->user();
            $user->delete();

            return HTTPResponse::send('success', 'successfully delete user', 200, null, null);

        } catch (Exception $e) {
            error_log("[USER Service][delete] error: " . $e->getMessage());
            return HTTPResponse::send('error', 'failed to delete user', 500);
        }
    }

    public function fetchUser(Request $request)
    {
        try {
            $user = $request->user();
            $user = $user->load('mutations', 'mutations.item');
            return HTTPResponse::send('success', 'successfully fetch user data', 200, $user);
        } catch (Exception $e) {
            error_log("[USER Service][fetchUser] error: " . $e->getMessage());
            return HTTPResponse::send('error', 'failed to fetch user', 500);
        }
    }
}
