<?php

namespace App\Http\Requests\buyer\Address;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole('buyer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:255'],

            'type' => ['required', 'string', 'max:100'],

            'street' => ['required', 'string', 'max:255'],

            'city' => ['required', 'string', 'max:255'],

            'region' => ['nullable', 'string', 'max:255'],

            'phone' => ['nullable', 'string', 'max:50'],

            'instructions' => ['nullable', 'string'],
        ];
    }
}
