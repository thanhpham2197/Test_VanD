<?php

namespace App\Http\Requests;

use App\Trait\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class BaseFormRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Custome fail validation
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                ['errors' => $errors],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}