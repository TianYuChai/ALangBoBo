<?php

namespace App\Http\Requests\home;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'account' => 'required',
            'password' => 'required',
            'category' => 'required|numeric',
            'name' => 'required',
            'id' => ['required', function($attribute, $value, $fail) {
                    if(!is_idcard($value)) {
                        return $fail('身份证不合规定');
                    }
            }],
            'mobile' => ['required', function($attribute, $value, $fail) {
                    if(!is_mobile($value)) {
                        return $fail('手机号码错误');
                    }
            }],
            'verifyCode' => 'required',
            'type' => 'required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '账号不可为空',
            'password.required' => '密码不可为空',
            'category.required' => '请选择分类',
            'category.numeric' => '账户类型错误',
            'name.required' => '姓名不可为空',
            'id.required' => '身份证不可为空',
            'mobile.required' => '手机号不可为空',
            'verifyCode.required' => '请填写验证码',
            'type.required' => '请阅读注册协议',
            'type.accepted' => '请阅读注册协议'
        ];
    }
}
