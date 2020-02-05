<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model {
    protected $fillable = [
        'nome', 'descricao', 'path', 'extensao', 'modificado', 'size', 'idAutor', 'idRepositorio'
    ];

    // 1 para 1

    public function Repositorio() {
        return $this->hasOne( 'App\Models\Repositorio', 'id', 'idRepositorio' );
    }
    // 1 para 1

    public function User() {
        return $this->hasOne( 'App\User', 'id', 'idAutor' );
    }

    /// $rootValue

    public function getAutor() {
        return  $this->User;
    }

    public function getRepositorio() {
        return  $this->Repositorio;
    }
}
