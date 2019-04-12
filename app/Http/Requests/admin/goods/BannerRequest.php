<?php

namespace App\Http\Requests\admin\goods;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'url' => 'required|url',
            'section_time' => 'required|string',
            'sort' => 'required|numeric',
            'banner_image_url' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'url.required' => '链接地址不可为空',
            'url.url' => '链接地址需要为有效地址',
            'section_time.required' => '上下架时间不可为空',
            'section_time.string' => '上下架时间类型错误',
            'sort.required' => '排序值不可为空',
            'sort.numeric' => '排序值需为数字',
            'banner_image_url.required' => '图片地址不可为空',
            'banner_image_url.string' => '图片地址类型错误'
        ];
    }
}
