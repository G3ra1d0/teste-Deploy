<?php

namespace App\GraphQL\Mutations\Auth;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login extends BaseAuthResolver
{
    public function __invoke($rootValue, array $args, GraphQLContext $context= null, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $credentials = $this->buildCredentials($args);
        $response = $this->makeRequest($credentials);
        $model = app(config('auth.providers.users.model'));
        $user = $model->where(config('lighthouse-graphql-passport.username'), $args['username'])->firstOrFail();
        $response['user'] = $user;
        return $response;
    }

}
