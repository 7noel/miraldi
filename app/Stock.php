<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'STKART';
    protected $primaryKey = 'STCODIGO';
    // protected $primaryKey = ['STALMA', 'STCODIGO'];
    protected $keyType = 'string';
    public $timestamps = false;
    
    public function price()
    {
        return $this->hasOne(Price::class, 'COD_ARTI', 'STCODIGO');
    }
}
