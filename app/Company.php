<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'MAECLI';
    protected $primaryKey = 'CCODCLI';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['CCODCLI','CNOMCLI','CDIRCLI','CTELEFO','CEMAIL','CNUMRUC','CDOCIDEN','CESTADO','DFECINS','CUSUARI','DFECCRE','DFECMOD','CVENDE','MONCRE','CTIPO_DOCUMENTO','CAPELLIDO_PATERNO','CAPELLIDO_MATERNO','CPRIMER_NOMBRE','TCL_CODIGO','UBIGEO'];

    public function scopeName($query, $name){
        if (trim($name) != "") {
            $query->where('CNOMCLI', 'LIKE', "%$name%")->orWhere('CCODCLI', 'LIKE', "%$name%");
        }
    }

}
