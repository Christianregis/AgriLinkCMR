<?php

namespace App\Http\Requests\buyer;

use Illuminate\Foundation\Http\FormRequest;

class BuyerProfileRequest extends FormRequest
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
            'name' => ['string', 'max:255', 'required'],
            'buyer_type' => ['required', 'in:person,company,institution,other'],
            'company_name' => ['string', 'max:255'],
            'profile_photo' => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
        ];
    }
}
