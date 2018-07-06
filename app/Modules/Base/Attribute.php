<?php

namespace App\Modules\Base;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model implements Auditable 
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['attribute_id', 'attribute_type', 'name', 'value'];

	public function attribute()
    {
        return $this->morphTo();
    }
}
