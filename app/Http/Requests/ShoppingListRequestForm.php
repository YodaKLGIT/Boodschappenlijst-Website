<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingListRequestForm extends FormRequest
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
            'name'          => 'required|string|max:255',
            'product_ids'   => 'nullable|array|max:255',
            'product_ids.*' => 'exists:products,id',
            'quantities'    => 'nullable|array',
            'quantities.*'  => 'integer|min:1',
            'list_id'       => 'nullable|exists:product_lists,id',
        ];
    }
}
