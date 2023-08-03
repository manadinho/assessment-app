<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'        => 'required|string',
            'description' => 'required|string',
            'names'       => 'required|array',
            'prices'      => 'required|array',
            'mainOptionsArrayData' => 'required|string'
        ];
        
        if(request()->has('id')) {
            $rules['id'] = 'exists:products,id';
        }

        return $rules;
    }
}
