<?php

namespace App\Http\Requests\form;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            // Le type de compte qu'on veut creer
            'account_type' => ['required', 'string', 'in:buyer,farmer'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'name' => ['required', "string", "max:255", 'required'],
            'email' => ['email', 'string', 'max:255', 'required', 'unique:users,email'],
            'password' => ['string', 'min:8', 'required'],
            'region_id' => ['exists:regions,id', 'nullable'],
            'village' => ['string', 'max:255', 'nullable'],
            'cultures' => ['string', 'nullable'],
            'profile_photo' => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
            'company_name' => ['string', 'max:255', 'nullable'],
            'certifications' => ['string', 'url', 'nullable'],
            'buyer_type' => ['string', 'in:person,company,institution,other', 'nullable']
        ];
    }
}
