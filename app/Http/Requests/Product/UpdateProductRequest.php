<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string,  array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            "title" => ["required", "string", "max:255"],
            "slug" => ["nullable", "string", "max:255", 'exists:products,slug'],
            "description" => ["nullable", "string"],
            "quantity" => ["required", "integer", "min:1"],
            "unit" => ["required", "string", "max:50"],
            "price" => ["required", "numeric", "min:0"],
            "min_order_qty" => ["required", "integer", "min:1"],
            "price_negotiable" => ["boolean"],
            "harvest_date" => ["nullable", "date"],
            "expires_at" => ["nullable", "date", "after_or_equal:harvest_date"],
            "status" => ["required", "string", 'in:available,out_of_stock,coming_soon'],
            "category_id" => ["required", "exists:categories,id"],
            "region_id" => ["required", "exists:regions,id"],
            "new_images" => ["nullable", "array", "max:6"], // Max 6 total images (existing + new)
            "new_images.*" => ["image", "mimes:jpg,jpeg,png", "max:2048"],
            "deleted_image_ids" => ["nullable", "array"],
            "deleted_image_ids.*" => ["integer", "exists:product_images,id"],
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Le titre est obligatoire",
            "price.required" => "Le prix est obligatoire",
            "quantity.min" => "La quantité doit être supérieure à 0",
            "expires_at.after_or_equal" => "La date d’expiration doit être après la récolte",
            "new_images.max" => "Le nombre total d\"images (existantes + nouvelles) ne doit pas dépasser 6.",
            "new_images.*.image" => "Le fichier doit être une image.",
            "new_images.*.mimes" => "L\"image doit être de type JPG, JPEG ou PNG.",
            "new_images.*.max" => "L\"image ne doit pas dépasser 2 Mo.",
        ];
    }
}
