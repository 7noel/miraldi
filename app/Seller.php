<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'VENDEDOR';
    protected $primaryKey = 'COD_VEN';
    protected $keyType = 'string';
    public $timestamps = false;
}
