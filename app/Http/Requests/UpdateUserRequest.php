<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserModel;

class UpdateUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        $id = $this->route('id');
        return UserModel::where('id', $id)->exists();
    }

    public function rules(): array
    {
        return [
            "name" => "string",
            "email" => "nullable|unique:users,email,".$this -> id,
            "password" => "min:6|confirmed",
            "role" => ['string']
        ];
    }
}
