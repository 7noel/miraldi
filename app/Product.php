<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'MAEART';
    protected $primaryKey = 'ACODIGO';
    protected $keyType = 'string';
    public $timestamps = false;

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'STCODIGO', 'ACODIGO');
    }

    public function price()
    {
        return $this->hasOne(Price::class, 'COD_ARTI', 'ACODIGO');
    }

    public function family()
    {
        return $this->hasOne(Family::class, 'FAM_CODIGO', 'AFAMILIA');
    }

    public function lockers()
    {
        return $this->hasMany(Locker::class, 'TCODART', 'ACODIGO');
    }
}
