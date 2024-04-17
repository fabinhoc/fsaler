<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'integer|required|exists:categories,id',
            'name' => 'string|required',
            'ean' => 'string|nullable',
            'cost_price' => 'decimal:0,2|nullable',
            'price' => 'decimal:0,2|required',
            'purchase_date' => 'nullable|date_format:Y-m-d',
            'is_paid' => 'boolean|nullable',
            'description' => 'nullable',
            'quantity' => 'integer|nullable',
        ];
    }
}
