<?php
namespace App\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

trait ApiErrorResponse{

    public function failedValidation(Validator $validator ){
        throw new HttpResponseException(response()->json([
            // 'success' => false,
            'status' => 401,
            'message' => $validator->errors(),
            // 'errors' => $validator->errors()
        ]));
    }
}