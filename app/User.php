<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Empresa;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'sobrenome', 'admin', 'email', 'password', 'cpf', 'status'
    ];

    //  Atributo padrão
    protected $attributes = [
        'status' => 'Ativo',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // N para N

    public function Telefones() {
        return $this->belongsToMany( 'App\Models\Telefone', 'users_telefones', 'idUser', 'idTelefone' );
    }
    // N para N

    public function Grupos() {
        return $this->belongsToMany( 'App\Models\Grupo', 'users_grupos', 'idUser', 'idGrupo' );
    }

    /// $rootValue

    public function getTelefones() {
        return  $this->Telefones;
    }

    public function getGrupos() {
        return  $this->Grupos;
    }

    public function getResponsavel() {
        return $this->admin == 1 ? Empresa::get() : Empresa::where( 'idResponsavel', $this->id )->get();
    }
}
