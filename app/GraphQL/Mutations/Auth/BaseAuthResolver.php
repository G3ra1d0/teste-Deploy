<?php

namespace App\GraphQL\Mutations\Auth;

use Illuminate\Http\Request;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class BaseAuthResolver
{
    public function buildCredentials(array $args = [], $grantType = "password")
    {
        $args = collect($args);
        $credentials = $args->except('directive')->toArray();
        $credentials['client_id'] = config('lighthouse-graphql-passport.client_id');
        $credentials['client_secret'] = config('lighthouse-graphql-passport.client_secret');
        $credentials['grant_type'] = $grantType;
        return $credentials;
    }

    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials,[], [], [
            'HTTP_Accept' => 'application/json'
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['message']);
        }
        return $decodedResponse;
    }
}
