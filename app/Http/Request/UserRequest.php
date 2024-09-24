<?php

namespace App\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRequest extends Request
{
    public function validate(array $data)
    {
        $validation = Validator::make($data, $this->registerRules());

        return $validation;
    }

    private function registerRules()
    {
        return [
            'name' => 'required|min:5|max:200',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:100'
        ];
    }
}
