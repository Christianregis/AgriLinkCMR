<?php

namespace App\Http\Requests\Buyer\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('buyer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'delivery_method' => ['required', 'in:delivery,pickup'],
            'delivery_address' => ['nullable', 'string', 'max:255', Rule::requiredIf($this->delivery_method === 'delivery')],
            'payment_method' => ['required', 'in:momo,cash,stripe'],
            'note' => ['nullable', 'string', 'max:500'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'Le panier ne peut pas être vide.',
            'items.min' => 'Le panier doit contenir au moins un article.',
            'items.*.product_id.required' => 'L\'ID du produit est requis.',
            'items.*.product_id.exists' => 'Le produit sélectionné n\'existe pas.',
            'items.*.quantity.required' => 'La quantité du produit est requise.',
            'items.*.quantity.min' => 'La quantité du produit doit être au moins de 1.',
            'items.*.price.required' => 'Le prix du produit est requis.',
            'items.*.price.numeric' => 'Le prix du produit doit être un nombre.',
            'items.*.price.min' => 'Le prix du produit doit être positif.',
            'delivery_method.required' => 'Le mode de livraison est requis.',
            'delivery_method.in' => 'Le mode de livraison sélectionné est invalide.',
            'delivery_address.required' => 'L\'adresse de livraison est requise pour la livraison à domicile.',
            'delivery_address.max' => 'L\'adresse de livraison ne peut pas dépasser 255 caractères.',
            'payment_method.required' => 'Le mode de paiement est requis.',
            'payment_method.in' => 'Le mode de paiement sélectionné est invalide.',
            'note.max' => 'La note ne peut pas dépasser 500 caractères.',
            'total_amount.required' => 'Le montant total est requis.',
            'total_amount.numeric' => 'Le montant total doit être un nombre.',
            'total_amount.min' => 'Le montant total doit être positif.',
        ];
    }
}
