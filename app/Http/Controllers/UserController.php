<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userSvc;

    public function __construct()
    {
        $this->userSvc = new UserService();
    }

    public function register(Request $request)
    {
        return $this->userSvc->register($request);
    }

    public function login(Request $request)
    {
        return $this->userSvc->login($request);
    }

    public function update(Request $request)
    {
        return $this->userSvc->update($request);
    }

    public function fetchProfile(Request $request)
    {
        return $this->userSvc->fetchUser($request);
    }
}
