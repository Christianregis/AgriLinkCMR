<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],

            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:50'],

            'price' => ['required', 'numeric', 'min:0'],
            'min_order_qty' => ['nullable', 'integer', 'min:1'],

            'price_negotiable' => ['boolean'],

            'harvest_date' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:harvest_date'],

            'status' => ['required', 'string', 'in:avaliable,out_of_stock,coming_soon'],

            'category_id' => ['required', 'exists:categories,id'],
            'region_id' => ['required', 'exists:regions,id'],

            // images
            'images' => ['nullable', 'array', 'max:6', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return             [
            'title.required' => 'Le titre est obligatoire',
            'price.required' => 'Le prix est obligatoire',
            'quantity.min' => 'La quantité doit être supérieure à 0',
            'expires_at.after_or_equal' => 'La date d’expiration doit être après la récolte',
            'image.min' => "Le nombre d'images doit etre superieur a 1",
            'image.max' => "Le nombre d'image doit etre inferieur a 6"
        ];
    }
}
