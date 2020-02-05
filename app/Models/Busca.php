<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Busca extends Model
{
    protected $fillable = [
        'ocr', 'page', 'idArquivo'
    ];


    public $timestamps = false;

    
    // 1 para 1
    public function Arquivo()
    {
        return $this->hasOne('App\Models\Arquivo', 'id' , 'idArquivo');
    }
}
