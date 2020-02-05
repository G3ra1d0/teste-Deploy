<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cnpj', 'razaoSocial', 'nomeFantasia', 'status', 'dataSuspensao', 'idEndereco', 'idResponsavel'
     ];
     
    //  Atributo padrão
    protected $attributes = [
        'status' => "Ativo",
    ];

    // 1 para 1
    public function Endereco()
    {
        return $this->hasOne('App\Models\Endereco', 'id' , 'idEndereco');
    }
    // 1 para 1
    public function Responsavel()
    {
        return $this->hasOne('App\User', 'id', 'idResponsavel');
    }
    // N para N
    public function Telefones()
    {
        return $this->belongsToMany('App\Models\Telefone', 'empresas_telefones' , 'idEmpresa' , 'idTelefone');
    }

    /// $rootValue
    public function getEndereco(){
        return  $this->Endereco;
    }

    public function getTelefone(){
        return  $this->Telefones;
    }

    public function getResponsavel(){
        return  $this->Responsavel;
    }

}
