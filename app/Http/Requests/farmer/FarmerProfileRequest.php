<?php

namespace App\Http\Requests\farmer;

use Illuminate\Foundation\Http\FormRequest;

class FarmerProfileRequest extends FormRequest
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
            // 'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'name' => ['required', "string", "max:255", 'required'],
            'region_id' => ['exists:regions,id', 'nullable'],
            'village' => ['string', 'max:255', 'nullable'],
            'bio' => ['string', 'max:255', 'nullable'],
            'cultures' => ['array', 'nullable'],
            'profile_photo' => ['image', 'mimes:png,jpg,jpeg', 'max:2048', 'nullable'],
        ];
    }
}
