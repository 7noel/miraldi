<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'FORMA_PAGO';
    protected $primaryKey = 'COD_FP';
    protected $keyType = 'string';
    public $timestamps = false;
}
