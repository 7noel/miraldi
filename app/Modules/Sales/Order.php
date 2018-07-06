<?php

namespace App\Modules\Sales;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['company_id', 'document_type_id', 'payment_condition_id', 'currency_id', 'seller_id', 'attention', 'matter', 'approved_at', 'checked_at', 'invoiced_at', 'sent_at', 'canceled_at', 'gross_value', 'discount', 'subtotal', 'tax', 'total', 'amortization', 'exchange', 'exchange_sunat', 'comment', 'status', 'delivery_period', 'installation_period', 'delivery_place', 'offer_period', 'mov', 'type_op'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%")->orWhere('created_at', 'LIKE', "%name%");
		}
	}
	public function company()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','company_id');
	}
	public function document_type()
	{
		return $this->hasOne('App\Modules\Base\DocumentType','id','document_type_id');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function payment_condition()
	{
		return $this->hasOne('App\Modules\Finances\PaymentCondition','id','payment_condition_id');
	}
	public function seller()
	{
		return $this->hasOne('App\Modules\HumanResources\Employee','id','seller_id');
	}
	public function details()
	{
		return $this->hasMany('App\Modules\Sales\OrderDetail');
	}
	public function attributes()
	{
		return $this->morphMany('App\Modules\Base\Attribute', 'attribute');
	}
}
