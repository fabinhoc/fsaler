<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'sometimes|integer|required|exists:clients,id',
            'payment_type_id' => 'sometimes|integer|required|exists:payment_types,id',
            'payment_date' => 'nullable|date_format:Y-m-d',
            'total' => 'sometimes|required|decimal:0,2',
            'discount' => 'nullable|decimal:0,2',
            'discount_type' => 'required_if:discount,!=,null|in:percentual,real',
            'description' => 'nullable',
            'total_paid' => 'nullable|decimal:0,2',
            'is_paid' => 'boolean|nullable',
            'status' => [Rule::enum(OrderStatusEnum::class)],
            'products' => 'sometimes|required|array',
            'products.*.product_id' => 'sometimes|integer|required|exists:products,id',
            'products.*.price' => 'sometimes|required|decimal:0,2',
            'products.*.quantity' => 'sometimes|integer|required|min:1',
        ];
    }
}
