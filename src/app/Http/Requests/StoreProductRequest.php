<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "NAME" => ["required", "min:10"],
            "ARTICLE" => ["required", "regex:/^[A-Za-z0-9]+$/", "unique:products"],
            "AVAILABLE" => ["required", "in:available,unavailable"],
            "ATTRS" => ["nullable"],
        ];
    }

    public function messages()
    {
       return  [
           "NAME.min" => "Название должно быть длинной от 10 символов",
           "ARTICLE.unique" => "Продукт с таким артикулем уже существует",
           "ARTICLE.regex" => "Артикул должен содержать только латинские символы и цифры",
        ];
    }

}
