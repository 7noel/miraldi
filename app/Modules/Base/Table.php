<?php

namespace App\Modules\Base;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model implements Auditable 
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['type', 'my_company', 'name', 'date', 'description', 'symbol', 'code', 'value_1', 'value_2', 'value_3', 'relation_id', 'table_id', 'table_type'];

	public function table()
    {
        return $this->morphTo();
    }
    public function pather()
    {
    	return $this->belongsTo('App\Modules\Base\Table', 'relation_id');
    }
}
