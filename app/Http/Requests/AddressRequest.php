<?php

namespace App\Http\Requests;

use App\Traits\ApiErrorResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    use ApiErrorResponse;
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
            'customer_id' => 'required|exists:customers,id',
            'house_address' => 'required',
            'street_address' => 'required',
            'house_address' => 'required',
            'locality' => 'required',
            'pincode' => 'nullable',
            // 'lat' => 'required',
            // 'long' => 'required',
        ];
    }
}
