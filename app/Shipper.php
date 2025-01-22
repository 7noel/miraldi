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

    public function setTRARAZEMPAttribute($value)
    {
        $this->attributes['TRARAZEMP'] = substr($value, 0, 50); // Truncar a 50 caracteres
    }
    public function setTRANOMBREAttribute($value)
    {
        $this->attributes['TRANOMBRE'] = substr($value, 0, 50); // Truncar a 50 caracteres
    }
    public function setTRADIRAttribute($value)
    {
        $this->attributes['TRADIR'] = substr($value, 0, 100); // Truncar a 100 caracteres
    }
    public function setTRADIREMPAttribute($value)
    {
        $this->attributes['TRADIREMP'] = substr($value, 0, 100); // Truncar a 100 caracteres
    }
}
