<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Grupo;

class GrupoMutation {
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

    public function Create( $rootValue, array $args ) {
        $grupo = Grupo::create( [
            'nome'          => $args['nome'],
            'descricao'  => isset( $args['descricao'] ) ? $args['descricao'] : null ,
            'idEmpresa' => $args['idEmpresa'],
        ] );

        if ( isset( $args['users'] ) ) $grupo->User()->sync( $args['users'] );
        if ( isset( $args['repositorios'] ) ) $grupo->Repositorios()->sync( $args['repositorios'] );

        return $grupo;

    }

    public function Update( $rootValue, array $args ) {

        $grupo = Grupo::find( $args['id'] );
        if ( !empty( $grupo ) ) {
            if ( isset( $args['nome'] ) ) $grupo->nome = $args['nome'] ;
            if ( isset( $args['idEmpresa'] ) ) $grupo->idEmpresa = $args['idEmpresa'];

            if ( isset( $args['descricao'] ) ) {
                $grupo->descricao = $args['descricao'] ;
            } else {
                $grupo->descricao = null;
            }
            $grupo->update();

            if ( isset( $args['users'] ) ) $grupo->User()->sync( $args['users'] );

            $temp = [];
            foreach ( $args['repositorios'] as $value ) {
                $temp[ $value['idRepositorio']] = ['papel' => $value['Papel'] ]  ;
            }

            if ( count( $temp ) > 0 ) $grupo->Repositorios()->sync( $temp );

            return  $grupo ;
        } else {
            return null;
        }
    }

    public function Delete( $rootValue, array $args ) {

        $grupo = Grupo::find( $args['id'] );

        if ( !empty( $grupo ) ) {
            $grupo->Repositorios()->sync( [] );
            $grupo->User()->sync( [] );
            $grupo->delete();
            return $grupo;

        } else {
            return null;
        }
    }

    // public function Privot( $rootValue, array $args ) {

    //         $grupo = Grupo::find( $args['id'] );

    //         if ( !empty( $grupo ) ) {
    //             return [ $grupo->->Repositorios();
    //         } else {
    //             return null;
    //         }
    //    }

}
