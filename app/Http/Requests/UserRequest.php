<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|without_spaces|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|numeric|unique:users',
            'password' => 'string|min:8|confirmed',
            'name' => 'required|string|name',
            'photo'=> 'required|string|name',
            'genere'=> 'required|string|name',
            'country'=> 'required|string|name',
            'province'=> 'required|string|name',
        ];
    }
}
