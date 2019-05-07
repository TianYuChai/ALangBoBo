<?php

namespace App\Http\Requests\home\persanal;

use Illuminate\Foundation\Http\FormRequest;

class PersanalAddressRequest extends FormRequest
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
            'eprovince' => 'required',
            'city' => 'required',
            'district' => 'required',
            'detailed' => 'required',
            'number' => ['required', function($attribute, $value, $fail) {
                if(!is_mobile($value)) {
                    return $fail('手机号码错误');
                }
            }],
            'type' => 'required',
            'contacts' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'eprovince.required' => '请选择地址：省',
            'city.required' => '请选择地址：市',
            'district.required' => '请选择地址：区',
            'detailed.required' => '请填写详细地址',
            'number.required' => '请填写手机号码',
            'type.required' => '缺少类型',
            'contacts.required' => '联系人不可为空'
        ];
    }
}
