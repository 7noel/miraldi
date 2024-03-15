<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $connection = "sqlsrv";
    protected $table = 'PEDDET';
    protected $primaryKey = 'DFNUMPED';
    // protected $primaryKey = ['DFNUMPED', 'DFSECUEN'];
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['DFNUMPED','DFSECUEN','DFCODIGO','DFDESCRI','DFCANTID','DFPREC_VEN','DFPREC_ORI','DFDESCTO','DFIGV','DFDESCLI','DFDESESP','DFIGVPOR','DFPORDES','DFIMPUS','DFIMPMN','DFALMA','DFCANREF','DFSALDO','DFUNIDAD', 'DFARTIGV'];

    public function order()
    {
        return $this->belongsTo(Order::class,'DFNUMPED','CFNUMPED');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'ACODIGO', 'DFCODIGO');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'STCODIGO', 'DFCODIGO');
    }
}
