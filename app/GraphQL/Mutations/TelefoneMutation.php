<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Telefone;

class TelefoneMutation
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
        
    }

    public static function CreateTelefone($rootValue, array $args)
    {
        return Telefone::firstOrCreate(['numero' => $args['numero'] ]);
    }

    public static function UpdateTelefone ($rootValue, array $args)
    {
        $tel = Telefone::find($args['id']);

        if(!empty($tel)){

            $tel->numero = $args['numero'];
            $tel->save();
            return $tel;

        }else{
            return null;
        }
    }

    public static function DeleteTelefone($rootValue, array $args)
    {
        $tel = Telefone::find($args['id']);

        if(!empty($tel)){
            $tel->delete();
            return $tel;

        }else{
            return null;
        }
    }

   
}
