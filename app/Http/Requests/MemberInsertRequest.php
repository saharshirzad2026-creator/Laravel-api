<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberInsertRequest extends FormRequest
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
            "name"=> "required|string|min:3|max:20",
            "email"=> ["required","string",
            Rule::unique('members','email')->ignore($this->route('member'),'id'),
            ],
            "address"=> "required|text|min:5|max:130",
            "whatsApp_number"=> "nullable|string",
        ];
    }
}
