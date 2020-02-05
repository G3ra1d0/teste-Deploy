<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Repositorio as modelRepositorio;
use Illuminate\Support\Facades\DB;

class Repositorio {
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
        if ( !empty( $args['id'] ) ) {
            return  modelRepositorio::find( $args['id'] );
        } else {
            return null;
        }
    }

    public function whereNome( $rootValue, array $args ) {

        // return json_encode( auth()->user()->Grupos'Pivot'] );

        $modelRepositorio = modelRepositorio::where( [
            ['nome', 'like', '%' . $args['nome'] . '%'],
            ['idEmpresa', '=', $args['idEmpresa'] ]
        ] )->get();

        if ( count( auth()->user()->getResponsavel() ) > 0 ) {
            return $modelRepositorio;
        } else {
            $data = [];
            // $modelRepositorio = new modelRepositorio();
            // precore os grupos
            foreach ( auth()->user()->Grupos as $key => $grupoIndividual ) {
                $temp = DB::table( 'repositorios' )
                ->select(
                    'repositorios.id as id', 'repositorios.nome', 'repositorios.descricao', 'repositorios.idEmpresa',
                    'repositorios.idRepositorio', 'repositorios.created_at', 'repositorios.updated_at'
                )->join( 'grupos_repositorios', 'grupos_repositorios.idRepositorio', '=', 'repositorios.id' )
                ->join( 'grupos', 'grupos.id', '=', 'grupos_repositorios.idGrupo' )
                ->where( [
                    // ['repositorios.nome', 'like', '%' . $args['nome'] . '%'],
                    ['repositorios.idEmpresa', '=', $args['idEmpresa'] ],
                    ['grupos.id', '=', $grupoIndividual['pivot']['idGrupo'] ],
                    ['grupos_repositorios.papel', '=', 'Editor']
                ] )->get();

                // precore os repositorios que o grupo corresponde
                foreach ( $temp as $repositorioGrupo ) {
                    // precore Todos os possiveis candidados com a palavra chave no nome
                    foreach ( $modelRepositorio as $model ) {
                        // Verefica se repositorio da empresa com filtro no nome contem perfil de editar
                        if ( in_array( $repositorioGrupo->id, $this->caminhoRepositorio( null, ['id' => $model['id']] ) ) ) {
                            $data[] = $model;
                        }
                    }
                }
            }

            return   $data ;
        }
    }

    public function RepositorioPaiEmpresa( $rootValue, array $args ) {

        return  modelRepositorio::where( [
            ['idRepositorio', '=', null ],
            ['idEmpresa', '=', $args['idEmpresa'] ]
        ] )->orderBy( 'nome' )->get();

    }

    // public function filhoRepositorio( $id ) {
    //     $filhos = modelRepositorio::where( 'idRepositorio', '=', $id )->get();
    //     if ( !empty( $filhos ) ) {
    //         $listaFilhos = [];
    //         foreach ( $filhos as $value ) {
    //             $temp = $this->filhoRepositorio( $value['id'] );
    //             if ( !empty( $temp ) ) {
    //                 foreach ( $temp as $repositorio ) {
    //                     $listaFilhos[] = $repositorio;
    //                 }
    //             }
    //             $listaFilhos[] = $value;
    //             return $listaFilhos;
    //         }

    //     } else {
    //         return null;
    //     }

    // }

    public function caminhoRepositorio( $rootValue, array $args ) {
        $repositorio = new modelRepositorio();

        $string = $repositorio->caminhoID( $args['id'] );
        $array = explode( '[', $string );
        $string = implode( '', $array );
        $array = explode( ']', $string );
        array_pop( $array );
        return $array;
    }
}
