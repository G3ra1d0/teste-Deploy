<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Empresa;
use App\GraphQL\Mutations\EnderecoMutation as Endereco;
use App\GraphQL\Mutations\TelefoneMutation as Telefone;

class EmpresaMutation
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

    public function CreateEmpresa($rootValue, array $args){
         // return json_encode($args['Endereco']);

        $empresa = Empresa::create([
            'cnpj'          => $args['cnpj'],
            'razaoSocial'  => $args['razaoSocial'],
            'nomeFantasia' => $args['nomeFantasia'],
            'status'        => $args['status'],
            'dataSuspensao'        => isset($args['dataSuspensao']) ? $args['dataSuspensao'] : null,
            'idEndereco'   =>  Endereco::CreateEndereco( $rootValue , $args['Endereco'] )->id,
            'idResponsavel'   =>  $args['idResponsavel']
        ]);

        /// N telefones
        foreach ( $args['Telefones'] as $tel) {
            $telID[] = Telefone::CreateTelefone( $rootValue , $tel )->id;
        }
        $empresa->Telefones()->sync($telID);

        return $empresa;
    }

    public function UpdateEmpresa($rootValue, array $args){
        $empresa = Empresa::find($args['id']);

        if($empresa){
            if(isset($args['cnpj']) ) $empresa->cnpj = $args['cnpj'] ;
            if(isset($args['razaoSocial']) ) $empresa->razaoSocial = $args['razaoSocial'] ;
            if(isset($args['nomeFantasia']) ) $empresa->nomeFantasia = $args['nomeFantasia'] ;
            if(isset($args['status']) ) $empresa->status = $args['status'] ;
            if(isset($args['idResponsavel']) ) $empresa->idResponsavel = $args['idResponsavel'] ;
            $empresa->dataSuspensao = isset($args['dataSuspensao']) ? $args['dataSuspensao'] : null;
            
            $empresa->update();

            if(isset($args['Endereco']['id'])){
                $args['Endereco']['id'] = $empresa->idEndereco;
                Endereco::UpdateEndereco($rootValue,  $args['Endereco'] );
            }

            if(isset($args['Telefones'])){
                /// N telefones
                foreach ( $args['Telefones'] as $tel) {
                  $telID[] = Telefone::CreateTelefone( $rootValue , $tel )->id;
                }
                $empresa->Telefones()->sync($telID);
            }

        return $empresa;
        
        }else{
            return null;
        }
    }

    public function DeleteEmpresa($rootValue, array $args){
        $emp = Empresa::find($args['id']);

        if(!empty($emp)){
            $emp->Telefones()->sync([]);
            $emp->delete();
            return $emp;

        }else{
            return null;
        }
    }

    // private function Retorno($empresa){
    //     return [
    //         'Empresa' => $empresa,
    //         'Telefones' => $empresa->getTelefone,
    //         'Responsavel' => $empresa->getResponsavel,
    //         'Endereco' => $$empresa->getEndereco
    //     ];
    // }

}
