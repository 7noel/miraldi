<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'MAETRAN';
    protected $primaryKey = 'TRACODIGO';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['TRACODIGO', 'TRANOMBRE', 'TRADIR', 'TRATELEF', 'TRARUC', 'TRAESTADO', 'TRAFECCRE', 'TRARAZEMP', 'TRARUCEMP', 'TRADIREMP', 'TRATELEMP', 'TRAPLACA', 'TRABREVE', 'MODELOVEH', 'NROINSCRIP', 'TRA_DNI', 'TRAHORARIO_ATENCION', 'TRANOMBRE_CONTACTO', 'TRATELEFONO_CONTACTO', 'TRAPERMISO_SUTRAN', 'TRAFECHAVENC_SUTRAN', 'TRANOMBRES', 'TRAAPELLIDOS', 'TRASECPLACA', 'FLGTRANSPORTE_PUBLICO', 'TRATIPO_DOCUMENTO'];

    public function scopeName($query, $name){
        if (trim($name) != "") {
            $query->where('TRANOMBRE', 'LIKE', "%$name%")->orWhere('TRACODIGO', 'LIKE', "%$name%");
        }
    }

}
