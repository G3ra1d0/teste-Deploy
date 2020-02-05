<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = [
        'id', 'numero'
    ];

    public $timestamps = false;

    // N para N
    public function Empresas()
    {
        return $this->belongsToMany('App\Models\Empresa', 'empresas_telefones' , 'idTelefone' , 'idEmpresa');
    }
    // N para N
    public function Users()
    {
        return $this->belongsToMany('App\User', 'users_telefones' , 'idTelefone' , 'idUser');
    }
}
