<?php

namespace App\Modules\Storage;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = ['ticket_id', 'quantity', 'stock_id', 'unit_id'];

	public function parent()
	{
		return $this->hasOne('App\Modules\Storage\Ticket','id','ticket_id');
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
