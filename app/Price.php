<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'LISTA_PRECIOS';
    protected $primaryKey = 'COD_ARTI';
    // protected $primaryKey = ['COD_LISPRE', 'COD_ARTI'];
    protected $keyType = 'string';
    public $timestamps = false;
}
