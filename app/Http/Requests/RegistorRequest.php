<?php

namespace App\Http\Requests;

use App\Traits\ApiErrorResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegistorRequest extends FormRequest
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
            'otp' => 'required',
            'otp_id' => 'required',
            'name' => 'required',
            'mobile' => 'required|unique:customers,mobile',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }
}
