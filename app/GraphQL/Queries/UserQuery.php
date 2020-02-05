<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

class UserQuery {
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

    public function userEmpresa( $rootValue, array $args ) {

        $sql =  'Select U.* from empresas E join grupos G on G.idEmpresa = E.id 
                         join users_grupos UG on G.id = UG.idGrupo 
                         join users U on UG.idUser = U.id
                         where E.id = ' . $args['idEmpresa'] . ' GROUP BY U.id';

        return DB::select( $sql );
    }
}
