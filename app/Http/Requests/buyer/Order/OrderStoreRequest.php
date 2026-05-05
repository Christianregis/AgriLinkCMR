<?php

namespace App\Http\Requests\Buyer\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['array', 'required'],
            'delivery_method' => ['required', 'string', 'in:delivery,pickup'],
            'delivery_address' => ['string', 'max:255', 'required'],
            'payment_method' => ['string', 'required', 'in:momo,cash, stripe'],
            'total_amount' => ['integer', 'required', 'min:1'],
        ];
    }
}
