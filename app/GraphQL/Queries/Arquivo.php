<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Arquivo as ModelArquivo;
use Illuminate\Support\Facades\DB;
use App\Models\Repositorio;

class Arquivo {
    /**
    * Return a value for the field.
    *
    * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
    * @param  mixed[]  $args The arguments that were passed into the field.
    * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
    * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
    * @return mixed
    */

    public function __invoke( $rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo ) {
        // TODO implement the resolver
    }

    public function arquivosRepositorio( $rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo ) {
        // TODO implement the resolver
        return ModelArquivo::where( 'idRepositorio', '=', $args['idRepositorio'] )->get();
    }

    public function search( $rootValue, array $args ) {
        $values = [];
        $sql = 'select a.* from arquivos a join repositorios r on r.id = a.idRepositorio join empresas e on e.id = r.idEmpresa ';

        if ( !empty( $args['conteudo'] ) ) {
            $sql .= ' join buscas b on b.idArquivo = a.id ';
        }

        $sql .= ' where e.id = '.$args['idEmpresa'].' ';

        if ( !empty( $args['idRepositorio'] ) ) {
            $sql .= ' and a.idRepositorio = '.$args['idRepositorio'].' ';
        }

        $opcoes = false;
        if ( !empty( $args['nome'] ) ) {
            if ( $opcoes == false ) {
                $sql .= ' and (';
                $opcoes = true;
            }
            $sql .= " a.nome like '%".$args['nome']."%' ";
        }

        if ( !empty( $args['descricao'] ) ) {
            if ( $opcoes == false ) {
                $sql .= ' and (';
                $opcoes = true;
            } else {
                $sql .= ' or ';
            }
            $sql .= " a.descricao like '%".$args['descricao']."%' ";
        }

        if ( !empty( $args['updated_at'] ) ) {
            if ( $opcoes == false ) {
                $sql .= ' and (';
                $opcoes = true;
            } else {
                $sql .= ' or ';
            }
            $sql .= " a.updated_at like '%".$args['updated_at']."%' ";
        }

        if ( !empty( $args['conteudo'] ) ) {
            if ( $opcoes == false ) {
                $sql .= ' and (';
                $opcoes = true;
            } else {
                $sql .= ' or ';
            }
            $sql .= " b.ocr like '%".$args['conteudo']."%' ";
        }

        if ( $opcoes ) {
            $sql .= ' )';
        }

        $data = DB::select( $sql );

        if ( count( auth()->user()->getResponsavel() ) > 0 || auth()->user()->admin > 0 ) {
            return $data;
        } else {
            $idArquivos = [];
            // precorendo os arquivos possiveis
            foreach ( $data as $arquivo ) {
                // vereficando os grupos do usuario
                foreach ( auth()->user()->Grupos as $grupo ) {
                    // Grupo Pertence a empresa da bsuca
                    if ( $grupo['idEmpresa'] == $args['idEmpresa'] ) {
                        // para cada grupo existe n repositorios vereficando cada repositorio
                        foreach ( $grupo->getRepositorios() as $repositorio ) {
                            // verefica se repositorio esta contido no caminho do arquivo se sim salva id do arquvio
                            if ( in_array( $repositorio->id, $this->caminhoID( $arquivo->idRepositorio ) ) ) {
                                $idArquivos[] = $arquivo->id;
                            }
                        }
                    }
                }
            }
            // Tirando elementos repetidos no array pois como usuario pode esta em n e pode ter gupo que aponta para mesma pasta
            $unique = array_unique( $idArquivos );
            $temp = [];
            foreach ( $data as $arquivo ) {
                if ( in_array( $arquivo->id, $unique ) ) {
                    $temp[] = $arquivo;
                }
            }
            return  $temp;
        }

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
