<?php
// Comprobantes, factura, letra, NC, ND, Letra, Guia (emisión y recepcion)
namespace App\Modules\Finances;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proof extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['issued_at', 'is_import', 'proof_type', 'mov', 'type_op', 'placa', 'car_id', 'document_type_id', 'sn', 'series', 'number', 'is_downloadable', 'dispatch_note_date', 'dispatch_note_number', 'dam','my_company', 'company_id', 'company_store_id', 'transfer_reason_id', 'shipper_id', 'payment_condition_id', 'expired_at', 'currency_id', 'exchange', 'exchange2', 'discount', 'discount_items', 'with_tax', 'gross_value', 'subtotal', 'tax', 'interest', 'total', 'factor', 'amortization', 'seller_id', 'swap_id', 'swap_letter_id', 'reference_id','status_sunat', 'sunat_transaction', 'igv_code', 'response_sunat', 'response_voided', 'ticket_voided', 'email', 'email_1', 'email_2'];

	public function scopeName($query, $name){
		if (trim($name) != "") {
			$query->where('number', 'LIKE', "%$name%");
		}
	}
	public function scopeDate($query, $name){
		if (trim($name) != "") {
			$query->where('date', 'LIKE', "%$name%")->orWhere('number', 'LIKE', "%$name%");
		}
	}

	public function orders()
	{
		return $this->hasMany('App\Modules\Operations\Order');
	}
	public function document_type()
	{
		return $this->belongsTo('App\Modules\Base\Table','document_type_id');
	}
	public function mycompany()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','my_company');
	}
	public function company()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','company_id');
	}
	public function car()
	{
		return $this->belongsTo('App\Modules\Operations\Car', 'car_id');
	}
	public function shipper()
	{
		return $this->hasOne('App\Modules\Finances\Company','id','shipper_id');
	}
	public function payment_condition()
	{
		return $this->hasOne('App\Modules\Finances\PaymentCondition','id','payment_condition_id');
	}
	public function currency()
	{
		return $this->hasOne('App\Modules\Base\Currency','id','currency_id');
	}
	public function seller()
	{
		return $this->belongsTo('App\Modules\Finances\Company', 'seller_id');
	}
	public function reference()
	{
		return $this->hasOne('App\Modules\HumanResources\Employee', 'id', 'reference_id');
	}
	// public function swap()
	// {
	// 	return $this->hasOne('App\Modules\Finances\Swap','id','swap_id');
	// }
	public function details()
	{
		return $this->hasMany('App\Modules\Finances\ProofDetail')->orderBy('category_id', 'desc')->orderBy('sub_category_id', 'desc');
	}
	public function expenses()
	{
		return $this->morphMany('App\Modules\Base\Expense', 'expense');
	}
	public function amortizations()
	{
		return $this->hasMany('App\Modules\Finances\Amortization');
	}
	public function swap()
	{
		return $this->belongsto('App\Modules\Finances\Swap');
	}

}