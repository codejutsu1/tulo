<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'utility' => 'required|string',
            'variation_id' => 'required',
            'plan' => 'required|string',
            'original_price' => 'required|integer',
            'price' => 'required|integer',
            'service_id' => 'string',
        ];
    }
}
