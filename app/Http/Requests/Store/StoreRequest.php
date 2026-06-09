<?php

// ibrahim amar alfanani 5026231195

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            //
            'storeName' => 'required|string|max:255',
            'storeAddress' => 'required|string',
            'storeDesc' => 'nullable|string',
            'storePic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
