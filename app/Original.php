<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Original extends Model
{
    use HasFactory;
    protected $connection = "mysql";

    protected $fillable = ['CFNUMPED', 'read_only', 'discount_2', 'activated_at', 'comments', 'content'];
    protected $casts = [
        'content' => 'object',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'CFNUMPED', 'CFNUMPED');
    }
}
