<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'], 
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => ['string'] 
        ];
    }
}
