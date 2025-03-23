<?php

namespace App\Http\Requests\DeliveryBoy;

use App\Traits\ApiErrorResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateStatusRequest extends FormRequest
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
            'delivery_boy_id' => 'required',
            'order_id' => 'required',
            'status' => 'required',
        ];
    }
}
