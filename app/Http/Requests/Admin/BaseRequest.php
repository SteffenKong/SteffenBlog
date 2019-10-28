<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * 开启授权
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param Validator $validator
     * 以json形式返回错误信息
     */
    public function failedValidation(Validator $validator)
    {
        exit(json_encode([
            'code'=>004,
            'message'=>'数据提交错误',
            'errors'=>$validator->getMessageBag()->toArray()
        ]));
    }
}
