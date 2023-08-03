<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'  => 'required|string',
            'price' => 'required|numeric'
        ];

        if(request()->has('id')) {
            $rules['id'] = 'exists:options,id';
        }

        return $rules;
    }

    
}
