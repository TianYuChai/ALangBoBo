<?php

namespace App\Http\Requests\admin\goods;

use Illuminate\Foundation\Http\FormRequest;

class categoryRequest extends FormRequest
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
            'cate_name' => 'required',
            'sort' => 'required',
            'level' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cate_name.required' => '分类名称不可为空',
            'sort.required' => '请输入排序值',
            'level.required' => '请选择一级分类'
        ];
    }
}
