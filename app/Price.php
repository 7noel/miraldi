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
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['COD_LISPRE', 'COD_ARTI', 'PRE_ACT', 'PRE_ANT', 'DIA_HORA', 'USUA_RES', 'FLAG_IGVACT', 'FLAG_IGVANT', 'UNI_LISPRE', 'MON_PRE', 'PRECIO_BASE', 'POR_GASTOS_ADMINISTRATIVOS', 'POR_UTILIDAD'];
}
