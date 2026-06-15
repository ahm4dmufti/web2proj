<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    // Allow all authenticated users to submit this form
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Detect whether this is a create (POST) or update (PUT/PATCH) request
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:painting,antique_piece,vase,handcraft,old_electronic',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',

            // On update: 'sometimes' means only validate if the field is present.
            // A checkbox sends nothing when unchecked, so 'sometimes' prevents a validation error.
            // On create: 'required' ensures the field is explicitly set.
            'is_available' => $isUpdate ? 'sometimes|boolean' : 'required|boolean',
            'images'       => 'nullable|array|max:10',
            'images.*'     => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}