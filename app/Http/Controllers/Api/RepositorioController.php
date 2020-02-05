<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Repositorio;
use App\Models\Grupo;
use App\User;

class RepositorioController extends Controller {
    public function indexTree( $idEmpresa ) {
        return $this->EmpresaTree( $idEmpresa );
    }

    private function EmpresaTree( $idEmpresa, $idRepositorio = null ) {
        $dados = Repositorio::where( [
            ['idEmpresa', '=', $idEmpresa],
            ['idRepositorio', '=', $idRepositorio]
        ] )->orderBy( 'nome', 'desc' )->get();

        if ( !empty( $dados ) ) {
            $listaFilhos = [];
            foreach ( $dados as $value ) {
                $listaFilhos[] = [
                    'id' => $value['id'],
                    'nome' => $value['nome'],
                    'descricao' => $value['descricao'],
                    'children' => $this->EmpresaTree( $idEmpresa, $value['id'] )
                ];
            }
            return $listaFilhos;
        } else {
            return [];
        }
    }

    public function gruposTree( $idUser, $idEmpresa ) {

        // Quais grupos o usuario pertence
        $user = User::find( $idUser );
        $userGrupos = $user->getGrupos();

        // Quais desses grupo pertence a empresa Atual
        $pastas = [];
        foreach ( $userGrupos as $grupos ) {
            if ( $grupos['idEmpresa'] == $idEmpresa ) {
                foreach ( $grupos->getRepositorios() as $repositorios ) {
                    $pastas[] = [
                        'id' =>$repositorios['id'],
                        'nome' => $repositorios['nome'],
                        'papel' => $repositorios->pivot->papel,
                        'descricao' => $repositorios['descricao'],
                        'children' => $this->UserTree( $repositorios['id'], $repositorios->pivot->papel )
                    ];
                }
            }
        }

        // Verefica se possuir Pasta repetidos de grupos diferente
        $iguaisID = [];
        foreach ( $pastas as $indice => $valor ) {
            foreach ( $pastas as $value ) {
                if ( $valor['id'] == $value['id'] ) {
                    if ( !in_array( $valor['id'],  $iguaisID ) ) {
                        $iguaisID[] = $valor['id'];
                    }
                }
            }
        }

        // Se existir valores igual
        if ( count( $iguaisID ) > 0 ) {
            $result = [];
            // Precore todas as Pastas
            foreach ( $pastas as $indice => $valor ) {
                // verefica se a Pasta Atual é candidata a ter uma igual
                if ( in_array( $valor['id'],  $iguaisID ) ) {
                    // precore todas as Pastas Novamente
                    foreach ( $pastas as $value ) {
                        // Se a pasta anterior for igual a essa pelo id
                        if ( $value['id'] == $valor['id'] ) {
                            $temp = 0;
                            // verefica se ela ja foi adicionada no result
                            foreach ( $result as $key => $resultValor ) {
                                if ( $resultValor['id'] == $valor['id'] ) {
                                    $temp++;
                                    if ( $resultValor['papel'] == 'Editor' ) {

                                    } else if ( $valor['papel'] == 'Editor' ) {
                                        $result[$key] = $valor;
                                    }
                                }
                            }
                            if ( $temp == 0 ) {
                                $result[] = $valor;
                            }
                        }
                    }
                } else {
                    $result[] = $valor;
                }
            }
            return $result;
        }
        return $pastas;
    }

    private function UserTree( $idRepositorio = null, $papel = null ) {
        $dados = Repositorio::where( 'idRepositorio', '=', $idRepositorio )->orderBy( 'nome', 'desc' )->get();

        if ( !empty( $dados ) ) {
            $listaFilhos = [];
            foreach ( $dados as $value ) {
                $listaFilhos[] = [
                    'id' => $value['id'],
                    'nome' => $value['nome'],
                    'descricao' => $value['descricao'],
                    'papel' => $papel,
                    'children' => $this->UserTree( $value['id'], $papel )
                ];
            }
            return $listaFilhos;
        } else {
            return [];
        }
    }

    public function caminho( $id ) {
        $repositorio = new Repositorio();
        return $repositorio->caminho( $id );
    }

    public function caminhoID( $id ) {
        $array = [];
        $repositorio = new Repositorio();
        $string = $repositorio->caminhoID( $id );
        $array = explode( '[', $string );
        $string = implode( '', $array );
        $array = explode( ']', $string );
        array_pop( $array );
        return $array;
    }
}
