<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Arquivo;

class ArquivoMutation
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

    public function createArquivo($rootValue, array $args){

        return  json_encode($args);

        // $caminho = new RepositorioController();

        // $nome = $args['nome'];
        // $repositorio = $args['repositorio_id'];
        // $descricao = $args['descricao'];
        // $extensao = $args['file']('file')->extension();
        // $size = $args['file']('file')->getClientSize();
        // $path = $args['file']('file')->store($caminho->caminho($args['repositorio_id']));
        // $arquivo = Arquivo::create(
        //     [
        //         "nome" => $nome,
        //         "descricao" => $descricao,
        //         "extensao" => $extensao,
        //         "size" => $size,
        //         "path" => $path,
        //         "repositorio_id" => $repositorio
        //     ]
        // );
        // $nomeImagem = realpath(__DIR__ . "/../../../..") . "/storage/app/" . $path;

        // if ($extensao == "pdf") {
        //     $im = new \Imagick();
        //     $im->setResolution(300, 300);
        //     $im->readimage($nomeImagem); // Numero da pagina do arquivo .pdf 
        //     $num_pages = $im->getNumberImages();
        //     for ($i = 0; $i < $num_pages; $i++) {
        //         $im->setIteratorIndex($i);
        //         $im->setImageFormat('jpeg');
        //         $pathNovo = substr($path, 0, -4);
        //         $pathNovo = $pathNovo . ".jpeg";
        //         $salvaImagem = realpath(__DIR__ . "/../../../..") . "/storage/app/" . $pathNovo;
        //         $im->writeImage($salvaImagem); // Nome da imagem que será criada

        //         $ocr = new TesseractOCR();
        //         $ocr->image($salvaImagem);
        //         $ocr->lang('por');
        //         $texto = $ocr->run();

        //         $busca = Busca::create(
        //             [
        //                 "page" => $i,
        //                 "ocr" => $texto,
        //                 "arquivo_id" => $arquivo->id
        //             ]
        //         );
        //     }
        //     $im->clear();
        //     $im->destroy();
        // } else {
        //     $ocr = new TesseractOCR();
        //     $ocr->image($nomeImagem);
        //     $ocr->lang('por');
        //     $texto = $ocr->run();

        //     $busca = Busca::create(
        //         [
        //             "page" => 1,
        //             "ocr" => $texto,
        //             "arquivo_id" => $arquivo->id
        //         ]
        //     );
        // }

        // return $arquivo;
   }

//    public function UpdateEmpresa($rootValue, array $args){
//        $empresa = Empresa::find($args['id']);

//        if($empresa){
//            if(isset($args['cnpj']) ) $empresa->cnpj = $args['cnpj'] ;
//            if(isset($args['razaoSocial']) ) $empresa->razaoSocial = $args['razaoSocial'] ;
//            if(isset($args['nomeFantasia']) ) $empresa->nomeFantasia = $args['nomeFantasia'] ;
//            if(isset($args['status']) ) $empresa->status = $args['status'] ;
//            if(isset($args['idResponsavel']) ) $empresa->idResponsavel = $args['idResponsavel'] ;
//            $empresa->dataSuspensao = isset($args['dataSuspensao']) ? $args['dataSuspensao'] : null;
           
//            $empresa->update();

//            if(isset($args['Endereco']['id'])){
//                $args['Endereco']['id'] = $empresa->idEndereco;
//                Endereco::UpdateEndereco($rootValue,  $args['Endereco'] );
//            }

//            if(isset($args['Telefones'])){
//                /// N telefones
//                foreach ( $args['Telefones'] as $tel) {
//                  $telID[] = Telefone::CreateTelefone( $rootValue , $tel )->id;
//                }
//                $empresa->Telefones()->sync($telID);
//            }

//        return $empresa;
       
//        }else{
//            return null;
//        }
//    }

//    public function DeleteEmpresa($rootValue, array $args){
//        $emp = Empresa::find($args['id']);

//        if(!empty($emp)){
//            $emp->Telefones()->sync([]);
//            $emp->delete();
//            return $emp;

//        }else{
//            return null;
//        }
//    }
}
