<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repositorio extends Model {
    protected $fillable = [
        'nome', 'descricao', 'idEmpresa', 'idRepositorio'
    ];

    // 1 para 1

    public function Empresa() {
        return $this->hasOne( 'App\Models\Empresa', 'id', 'idEmpresa' );
    }
    // 1 para 1

    public function Repositorio() {
        return $this->hasOne( 'App\Models\Repositorio', 'idRepositorio' );
    }
    // N para N

    public function Grupos() {
        return $this->belongsToMany( 'App\Models\Grupo', 'grupos_repositorio', 'idRepositorio', 'idGrupo' );
    }

    /// $rootValue

    public function getFilhos( $rootValue ) {
        $temp = Repositorio::where( 'idRepositorio', $rootValue['id'] )->get();
        return $temp ? $temp : null;
    }

    public function getEmpresa() {
        return  $this->Empresa;
    }

    public function getRepositorio( $rootValue ) {
        // return  $this->Repositorio;
        $temp = Repositorio::where( 'id', $rootValue['idRepositorio'] )->first();
        return $temp ? $temp : null;
    }

    public function caminho( $id ) {
        $temp = $this->find( $id );
        if ( empty( $temp ) ) {
            return '';
        } else {
            return $this->caminho( $temp->idRepositorio ).'/'.$temp->nome;
        }
    }

    public function caminhoID( $id ) {
        $temp = $this->find( $id );
        if ( empty( $temp ) ) {
            return null;
        } else {
            return $this->caminhoID( $temp->idRepositorio ).'['.$temp->id.']';
            // return $this->caminhoID( $temp->idRepositorio ).'['.$temp->id.']';
        }
    }
}
