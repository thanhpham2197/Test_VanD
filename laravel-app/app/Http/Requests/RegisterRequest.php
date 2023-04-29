<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'              => ['bail', 'required', 'email:rfc,dns', 'unique:users,email'],
            'password'           => ['bail', 'required', 'max:16', 'min:8'],
            'password_confirmed' => ['bail', 'required', 'same:password']
        ];
    }
}
