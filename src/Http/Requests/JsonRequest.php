<?php

namespace Altenic\MaybeCms\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class JsonRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => collect($validator->errors())->map(fn($error) => $error[0]),
        ], 422));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->noContent(401));
    }
}
