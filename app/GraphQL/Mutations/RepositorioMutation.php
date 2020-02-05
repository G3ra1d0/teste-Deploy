<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Repositorio;

class RepositorioMutation
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
    }

    public function Create($rootValue, array $args){

       return Repositorio::create([
           'nome'          => $args['nome'],
           'descricao'  => isset($args['descricao']) ? $args['descricao'] : null,
           'idRepositorio' => isset($args['idRepositorio']) ? $args['idRepositorio']: null,
           'idEmpresa' => $args['idEmpresa'],
       ]);
   }
    public function Update($rootValue, array $args){

        $repo = Repositorio::find($args['id']);

        if( !empty($repo) ){
            if(isset($args['nome']) ) $repo->nome = $args['nome'] ;
            if(isset($args['descricao']) ) $repo->descricao = $args['descricao'] ;
            if(isset($args['idEmpresa']) ) $repo->idEmpresa = $args['idEmpresa'];
            
            if(isset($args['idRepositorio']) ){
                 $repo->idRepositorio = $args['idRepositorio'] ;
            }else{
                $repo->idRepositorio = null;
            }
            $repo->update();
            return $repo;
        }else{
            return null;
        }
   }
   
    public function Delete($rootValue, array $args){

        $repo = Repositorio::find($args['id']);

        if(!empty($repo)){
            $repo->delete();
            return $repo;

        }else{
            return null;
        }
   }

}
