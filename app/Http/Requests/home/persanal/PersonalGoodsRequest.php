<?php
/**
 * Created by PhpStorm.
 * User: chai
 * Date: 2019/5/22
 * Time: 16:42
 */
namespace App\Http\Requests\home\persanal;


use App\Http\Models\admin\goods\goodsCategoryModel;
use App\Http\Models\currency\MerchantCategoryModel;
use App\Http\Models\home\personal\AddressModel;
use Illuminate\Foundation\Http\FormRequest;
use FileUpload;

class PersonalGoodsRequest extends FormRequest
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
            'title' => 'required',
            'category' => ['required', function($attribute, $value, $fail) {
                if(count($value) < 3 || !goodsCategoryModel::whereIn('id', $value)->exists()) {
                    return $fail('商品分类错误, 请重新选择');
                };
            }],
            'nav_category' => ['required', function($attribute, $value, $fail) {
                if(!MerchantCategoryModel::where('id', intval($value))->exists()) {
                    return $fail('导航分类错误, 请重新选择');
                };
            }],
            'address' => [function ($attribute, $value, $fail) {
                    if($value) {
                        if(!AddressModel::where('id', intval($value))->exists()) {
                            return $fail('收货错误, 请重新选择');
                        }
                    }
            }],
            'total_price' => ['required', function ($attribute, $value, $fail) {
                    if(!is_numeric($value)) {
                        return $fail('总价错误, 请重新填写');
                    }
            }],
            'cost_price' => ['required', function ($attribute, $value, $fail) {
                if(!is_numeric($value)) {
                    return $fail('成本价错误, 请重新填写');
                }
            }],
            'satis_price' => ['required', function ($attribute, $value, $fail) {
                if(!is_numeric($value)) {
                    return $fail('满意度价错误, 请重新填写');
                }
            }],
            'stock' => ['required', function ($attribute, $value, $fail) {
                if(!is_int(intval($value))) {
                    return $fail('库存错误, 请重新填写');
                }
            }],
            'cover_img' => ['required', function ($attribute, $value, $fail) {
                if(!FileUpload::exists('image', $value)) {
                    return $fail('封面图错误, 请重新填写');
                }
            }],
            'rotation_chart' => ['required', function($attribute, $value, $fail) {
                foreach ($value as $item) {
                    if(!FileUpload::exists('image', $item)) {
                        return $fail('轮播图错误, 请重新填写');
                    }
                }
            }],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => '商品名称不可为空',
            'second_category.required' => '请选择分类',
            'nav_category.required' => '请选择导航分类',
            'total_price.required' => '请填写总价',
            'cost_price.requried' => '请填写成本价',
            'satis_price.requried' => '请填写满意度价',
            'stock.required' => '请填写库存',
            'cover_img.required' => '请上传封面图',
            'rotation_chart' => '请上传轮播图'
        ];
    }
}
