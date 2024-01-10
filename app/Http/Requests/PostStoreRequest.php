<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PostStoreRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'title' => 'required|string|max:180|unique:posts',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required|string',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response =  (new ErrorResource($validator->errors()))->response()->setStatusCode(422);

        throw new ValidationException($validator,$response);
    }
}
