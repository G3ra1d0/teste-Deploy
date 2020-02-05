<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Endereco;

class EnderecoMutation
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

    public static function CreateEndereco($rootValue, array $args){
        return Endereco::create([
            'rua' => $args['rua'],
            'numero' => isset($args['numero']) ? $args['numero'] : null,
            'cidade' => $args['cidade'],
            'estado' => $args['estado'],
            'cep'    => $args['cep'],
            'complemento' => isset($args['complemento']) ? $args['complemento'] : null,
            'bairro' => $args['bairro']
        ]);
    }

    public static function UpdateEndereco($rootValue, array $args)
    {
        $end = Endereco::find($args['id']);

        if( !empty($end) ){
            $end->rua = $args['rua'];
            $end->numero = isset($args['numero']) ? $args['numero'] : null;
            $end->cidade = $args['cidade'];
            $end->estado = $args['estado'];
            $end->cep = $args['cep'];
            $end->complemento = isset($args['complemento']) ? $args['complemento'] : null;
            $end->bairro = $args['bairro'];
            $end->update();
            return $end;
        }else{
            return null;
        }
    }

    public static function DeleteEndereco($rootValue, array $args)
    {
        $end = Endereco::find($args['id']);

        if(!empty($end)){
            $end->delete();
            return $end;

        }else{
            return null;
        }
    }
}
