<?php namespace App\Modules\Base;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model implements Auditable {

	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['url', 'is_picture', 'order', 'file_id', 'file_type'];

	public function file()
    {
        return $this->morphTo();
    }
}
