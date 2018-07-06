<?php

namespace App\Modules\Base;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements Auditable 
{
	use \OwenIt\Auditing\Auditable;
	use SoftDeletes;

	protected $fillable = ['comment_id', 'comment_type', 'body', 'user_id'];

	public function comment()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Post');
    }
}
