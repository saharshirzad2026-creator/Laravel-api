<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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
            "name"=> "nullable|string|min:3|max:20",
            "email"=> "nullable|string|min:10|max:40",
            "address"=> "nullable|text|min:5|max:130",
            "whatsApp_number"=> "nullable|string|min:10:max:10",
        ];
    }
}
