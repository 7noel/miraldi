<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Original extends Model
{
    use HasFactory;
    protected $connection = "mysql";

    protected $fillable = ['CFNUMPED', 'read_only', 'discount_2', 'activated_at', 'printed_at', 'print_count', 'approved_at', 'comments', 'content'];
    protected $casts = [
        'content' => 'object',
        'activated_at' => 'datetime',
        'printed_at'   => 'datetime',
        'approved_at'  => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'CFNUMPED', 'CFNUMPED');
    }
}
