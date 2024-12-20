<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProductlistRequestForm extends FormRequest
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
        'name' => 'required|string|max:255|unique:lists,name',
        'product_ids' => 'nullable|array',
        'product_ids.*' => 'exists:products,id',
        'quantities' => 'nullable|array',
        'quantities.*' => 'nullable|integer|min:0',
        'theme_id' => 'nullable|exists:themes,id',
        'user_ids' => 'nullable|array',
        'user_ids.*' => 'exists:users,id',
    ];
}
}
