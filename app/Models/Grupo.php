<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'idEmpresa'
    ];

    // N para N
    public function Repositorios()
    {
        return $this->belongsToMany('App\Models\Repositorio', 'grupos_repositorios' , 'idGrupo' , 'idRepositorio')->withPivot('papel');
    }
    // N para N
    public function User()
    {
        return $this->belongsToMany('App\User', 'users_grupos' , 'idGrupo' , 'idUser');
    }
    // 1 para 1
    public function Empresa()
    {
        return $this->hasOne('App\Models\Empresa', 'id', 'idEmpresa');
    }
        
    /// $rootValue
    public function getRepositorios(){
        return $this->Repositorios;
   }

    public function getRepositoriosPrivot(){
        $temp= [];
        foreach ($this->Repositorios as $repo) {
            $temp[] = [
                        'Repositorio' => $repo,
                        'Papel' => $repo->pivot->papel
            ];
        }
        return $temp;
   }

//     public function getRepositoriosPrivot(){
//         foreach ($this->Repositorios as $repo) {
//             $temp[] = $repo->pivot;
//         }
//         return $temp;
//    }

    public function getUsers(){
        return  $this->User;
    }

    public function getEmpresa(){
        return  $this->Empresa;
    }
}
