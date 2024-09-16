<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'TABCASILLERO';
    protected $primaryKey = 'TCODART';
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = ['TCODALM','TCODART','TCASILLERO'];
}
