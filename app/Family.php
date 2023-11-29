<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'FAMILIA';
    protected $primaryKey = 'FAM_CODIGO';
    protected $keyType = 'string';
    public $timestamps = false;
}
