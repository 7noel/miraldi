<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'PEDCAB';
    protected $primaryKey = 'CFNUMPED';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['CFNUMPED','CFFECDOC','CFFECVEN','CFVENDE','CFPUNVEN','CFCODCLI','CFNOMBRE','CFDIRECC','CFRUC','CFIMPORTE','CFPORDESCL','CFPORDESES','CFFORVEN','CFTIPCAM','CFCODMON','CFESTADO','CFUSER','CFGLOSA','CFORDCOM','CFIGV','CFDESCTO','CFDESIMP','CFDESVAL','CFCOTIZA','TIPO','IMP_CFNUMPED','FLG_PDMOVIL','FLG_PORTAL', 'COD_TRANSPORTISTA'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'DFNUMPED', 'CFNUMPED');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class, 'COD_VEN', 'CFVENDE');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'CCODCLI', 'CFCODCLI');
    }

    public function shipper()
    {
        return $this->hasOne(Shipper::class, 'TRACODIGO', 'COD_TRANSPORTISTA');
    }

    public function condition()
    {
        return $this->hasOne(Condition::class, 'COD_FP', 'CFFORVEN');
    }

    public function original()
    {
        return $this->hasOne(Original::class, 'CFNUMPED', 'CFNUMPED');
    }

    public function pickings()
    {
        return $this->hasMany(Picking::class, 'CFNUMPED', 'CFNUMPED');
    }
}
