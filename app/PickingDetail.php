<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['picking_id', 'CFNUMPED', 'codigo', 'codigo2', 'name', 'quantity', 'quantity_ordered', 'quantity_invoiced', 'quantity_pending_billing', 'invoiced_at', 'invoice', 'user_id'];

    public function picking()
    {
        return $this->belongsTo(Picking::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class,'CFNUMPED','CFNUMPED');
    }
}
