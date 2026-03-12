<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            "name"=> $validated->name,
            "email"=> $validated->email,
            "password"=> $validated->password
        ];
    }
    public function messages(){
        return[
            "name:required"=> "The name field is required",
            "name:min:3"=> "The name field must be at least three characters",
        ];
    }
}
