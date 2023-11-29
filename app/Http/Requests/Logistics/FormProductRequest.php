<?php namespace App\Http\Requests\Logistics;

use App\Http\Requests\Request;
use App\Modules\Storage\Product;
use Illuminate\Validation\Rule;

class FormProductRequest extends Request {

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
		$id = Request::route()->parameters()['product'] ?? null;
		// $model = Product::find($data) ?? 0;
		if (is_null($id)) {
			$id = Request::route()->parameters()['service'] ?? null;
		}
		//dd($id);
		// dd(Request::route()->parameters());
		return [
			// 'name'=>'required|unique:products,name'.((is_null($id)) ? '' : ','.$id) ,
			'name' => ['required', Rule::unique('products')->where(function ($query) {
		            return $query->where('my_company', session('my_company')->id)->whereNull('deleted_at');
		        })->ignore($id)],
			'intern_code' => ['required', Rule::unique('products')->where(function ($query) {
		            return $query->where('my_company', session('my_company')->id)->whereNull('deleted_at');
		        })->ignore($id)],
			//'provider_code'=>'required|unique:products,provider_code'.((empty($data)) ? '' : ','.$data['products']) ,
			//'manufacturer_code'=>'required|unique:products,manufacturer_code'.((empty($data)) ? '' : ','.$data['products']) ,
			'sub_category_id'=>'required|numeric',
			//'brand_id'=>'required|numeric',
			'unit_id'=>'required|numeric'
		];
	}

}

// 'column_1' => 'required|unique:TableName,column_1,' . $this->id . ',id,colum_2,' . $this->column_2

// 'data.ip' => 'required|unique:servers,ip,'.$this>id.'|unique:servers,hostname,'.$this->id