<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\GraphQL\Mutations\TelefoneMutation as Telefone;
use App\User;

class UserMutation
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
        $user = User::create([
            'name'          => $args['name'],
            'sobrenome'     => $args['sobrenome'],
            'email'         => $args['email'],
            'cpf'           => $args['cpf'],
            'password'      => $args['password'],     
            'status'      => $args['status'],     
            'admin'  => isset($args['admin']) ? $args['admin'] : 0 ,
        ]);

        if(isset($args['grupos']))  $user->grupos()->sync($args['grupos']);
        
        /// N telefones
        foreach ( $args['telefones'] as $tel) {
            $telID[] = Telefone::CreateTelefone( $rootValue , $tel )->id;
        }
        $user->Telefones()->sync($telID);

        return $user;
    }

    public function Update($rootValue, array $args){
        $user = User::find($args['id']);

        if( !empty($user) ){
            if(isset($args['name']) ) $user->name = $args['name'] ;
            if(isset($args['sobrenome']) ) $user->sobrenome = $args['sobrenome'] ;
            if(isset($args['email']) ) $user->email = $args['email'] ;
            if(isset($args['cpf']) ) $user->cpf = $args['cpf'] ;
            if(isset($args['status']) ) $user->status = $args['status'] ;
            if(isset($args['password']) ) $user->password = $args['password'] ;
            
            if(isset($args['admin']) ){
                $user->admin = $args['admin'] ;
            }else{
                $user->admin = 0;
            }
            
            $user->update();
            
            if(isset($args['grupos']) ) $user->grupos()->sync($args['grupos']);
            if(isset($args['telefones']) ){
                /// N telefones
                foreach ( $args['telefones'] as $tel) {
                    $telID[] = Telefone::CreateTelefone( $rootValue , $tel )->id;
                }
                $user->Telefones()->sync($telID);
            } 
            
            return $user;
        }else{
            return null;
        }
    }

    public function Delete($rootValue, array $args){

        $user = User::find($args['id']);

        if(!empty($user)){
            $user->Telefones()->sync([]);
            $user->Grupos()->sync([]);
            $user->delete();
            return $user;

        }else{
            return null;
        }
   }

}
