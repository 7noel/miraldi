<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picking extends Model
{
    use HasFactory;

    protected $fillable = ['CFNUMPED', 'user_id', 'items', 'pl', 'es'];
    protected $casts = [
        'detalles' => 'object',
    ];

    public function scopeName($query, $name){
        if (trim($name) != "") {
            $pedido =  str_pad($name, 7, "0", STR_PAD_LEFT);
            $query->where('CFNUMPED', $pedido)->orWhere('id', $name);
        }
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'CFNUMPED', 'CFNUMPED');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PickingDetail::class);
    }
}
