<?php
//ibrahim amar alfanani 5026231195
namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Autorisasinya akan kita tangani di Controller/Policy, 
     * jadi kita kembalikan true di sini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'itemName' => 'required|string|max:255',
            // Gunakan numeric jika input adalah angka, atau replace dengan decimal jika perlu
            'itemPrice' => 'required|integer|min:0' 
        ];
    }

    /**
     * error message.
     */
    public function messages(): array
    {
        return [
            'itemName.required' => 'Nama Item wajib diisi.',
            'itemPrice.required' => 'Harga Item wajib diisi.',
            'itemPrice.integer' => 'Harga Item harus berupa angka bulat.',
            'itemPrice.min' => 'Harga Item tidak boleh negatif.'
        ];
    }
}