<?php

namespace App\Modules\Storage;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = ['ticket_id', 'category_id', 'sub_category_id', 'quantity', 'stock_id', 'unit_id'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Storage\Ticket','id','ticket_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Modules\Base\Table','category_id');
	}
	public function sub_category()
	{
		return $this->belongsTo('App\Modules\Base\Table','sub_category_id');
	}
	public function stock()
	{
		return $this->hasOne('App\Modules\Storage\Stock','id','stock_id');
	}
	public function unit()
	{
		return $this->hasOne('App\Modules\Storage\Unit','id','unit_id');
	}
	public function moves()
	{
		return $this->morphMany('App\Modules\Storage\Move', 'move');
	}
}
