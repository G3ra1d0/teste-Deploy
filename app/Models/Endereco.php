<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
       'rua', 'numero', 'cidade', 'estado', 'cep', 'complemento', 'bairro'
    ];
    
    public $timestamps = false;

    // protected $keyType = 'string';

    // public $incrementing = false;

    // protected $primaryKey = 'flight_id';

    // protected $table = 'my_flights';

    // Atributo padrão
    // protected $attributes = [
    //     'delayed' => false,
    // ];
}
