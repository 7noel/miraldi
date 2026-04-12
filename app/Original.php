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
        'rejected_by'  => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'CFNUMPED', 'CFNUMPED');
    }
    
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activatedUser()
    {
        return $this->belongsTo(User::class, 'activated_by');
    }

    public function approvedUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function printedUser()
    {
        return $this->belongsTo(User::class, 'printed_by');
    }

    public function rejectedUser()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
