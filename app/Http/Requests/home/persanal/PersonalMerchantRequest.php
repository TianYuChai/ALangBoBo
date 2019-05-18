<?php
/**
 * Created by PhpStorm.
 * User: 天宇
 * Date: 2019/5/18
 * Time: 21:14
 */
namespace App\Http\Requests\home\persanal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PersonalMerchantRequest extends FormRequest
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
            'shopName' => 'required',
            'shehuiDaima' => 'required',
            'zheng' => 'required',
            'fan' => 'required',
            'category' => 'required',
            'verifyCode' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'shopName.required' => '请填写店名',
            'shehuiDaima.required' => '请填写统一社会信用代码',
            'zheng.required' => '请上传身份证正面',
            'fan.required' => '请上传身份证反面',
            'category.required' => '请选择入驻类别',
            'verifyCode.required' => '请输入验证码'
        ];
    }
}