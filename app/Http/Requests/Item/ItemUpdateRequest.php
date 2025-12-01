<?php
// app/Http/Requests/Item/ItemUpdateRequest.php
// ibrahim amar alfanani 5026231195

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autorisasi dilakukan di Controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'itemName' => 'required|string|max:255',
            'itemPrice' => 'required|numeric|min:0'
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'itemName.required' => 'Nama Item wajib diisi.',
            'itemName.string' => 'Nama Item harus berupa teks.',
            'itemName.max' => 'Nama Item tidak boleh lebih dari 255 karakter.',
            
            'itemPrice.required' => 'Harga Item wajib diisi.',
            'itemPrice.integer' => 'Harga Item harus berupa angka bulat.',
            'itemPrice.min' => 'Harga Item tidak boleh negatif.'
        ];
    }

    /**
     * Custom attribute names (optional, untuk pesan error yang lebih natural)
     */
}