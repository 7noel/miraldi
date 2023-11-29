<?php

namespace App\Modules\Operations;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_id', 'is_downloadable', 'order_type', 'car_id', 'placa', 'kilometraje', 'type_service', 'preventivo', 'branch_id', 'shipper_id', 'shipper_branch_id', 'my_company', 'document_type_id', 'payment_condition_id', 'currency_id', 'seller_id', 'repairman_id', 'attention', 'matter', 'approved_at', 'checked_at', 'invoiced_at', 'sent_at', 'canceled_at', 'gross_value', 'discount', 'discount_items', 'subtotal', 'tax', 'total', 'amortization', 'exchange', 'exchange_sunat', 'comment', 'status', 'delivery_period', 'installation_period', 'delivery_place', 'offer_period', 'mov', 'type_op', 'proof_id', 'user_id', 'sn', 'order_id', 'inventory'];
	protected $casts = [
		'inventory' => 'array',
	];
	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%")->orWhere('created_at', 'LIKE', "%name%");
		}
	}

	//CPE Relacionado
	public function proof()
	{
		return $this->belongsTo('App\Modules\Finances\Proof');
	}
	public function orders()
	{
		return $this->hasMany('App\Modules\Operations\Order', 'order_id');
	}
	public function quote()
	{
		return $this->belongsTo('App\Modules\Operations\Order', 'order_id');
	}
	public function mycompany()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'my_company');
	}
	public function company()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'company_id');
	}
	public function car()
	{
		return $this->belongsTo('App\Modules\Operations\Car', 'car_id');
	}
	public function shipper()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'shipper_id');
	}
	public function user()
	{
		return $this->belongsTo('App\Modules\Security\Company','user_id');
	}
	public function currency()
	{
		return $this->belongsTo('App\Modules\Base\Currency', 'currency_id');
	}
	public function payment_condition()
	{
		return $this->belongsTo('App\Modules\Finances\PaymentCondition', 'payment_condition_id');
	}
	public function seller()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'seller_id');
	}
	public function repairman()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'repairman_id');
	}
	public function details()
	{
		return $this->hasMany('App\Modules\Operations\OrderDetail')->orderBy('category_id', 'desc')->orderBy('sub_category_id', 'desc');
	}
	public function attributes()
	{
		return $this->morphMany('App\Modules\Base\Attribute', 'attribute');
	}
}
