<?php

namespace App\Modules\Base;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model implements Auditable 
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['currency_id', 'value', 'exchange', 'name', 'expense_id', 'expense_type'];

	public function expense()
    {
        return $this->morphTo();
    }
}
