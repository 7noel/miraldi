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
    protected $fillable = ['CCODCLI','CNOMCLI','CDIRCLI','CTELEFO','CEMAIL','CNUMRUC','CDOCIDEN','CESTADO','DFECINS','CUSUARI','DFECCRE','DFECMOD', 'DIRENT','CVENDE','MONCRE','CTIPO_DOCUMENTO','CAPELLIDO_PATERNO','CAPELLIDO_MATERNO','CPRIMER_NOMBRE','TCL_CODIGO','UBIGEO'];

    public function scopeName($query, $name){
        if (trim($name) != "") {
            $query->where('CNOMCLI', 'LIKE', "%$name%")->orWhere('CCODCLI', 'LIKE', "%$name%");
        }
    }

    public function ubigeo()
    {
        return $this->belongsTo(Ubigeo::class,'UBIGEO','code');
    }

    public function setCNOMCLIAttribute($value)
    {
        $this->attributes['CNOMCLI'] = substr($value, 0, 100); // Truncar a 100 caracteres
    }
    public function setCDIRCLIAttribute($value)
    {
        $this->attributes['CDIRCLI'] = substr($value, 0, 100); // Truncar a 100 caracteres
    }
    public function setDIRENTAttribute($value)
    {
        $this->attributes['DIRENT'] = substr($value, 0, 100); // Truncar a 100 caracteres
    }

}
