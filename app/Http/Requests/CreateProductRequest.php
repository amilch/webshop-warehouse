<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        return [
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'sku' => 'required|string',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }
}