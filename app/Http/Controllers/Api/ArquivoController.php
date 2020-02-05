<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\RepositorioController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Arquivo;
use App\Models\Busca;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ArquivoController extends Controller {

    public function __construct() {
        $this->middleware( 'auth:api' );
    }

    public function fileArquivo( $id ) {
        $arquivo = Arquivo::find( $id );
        return response()->file( storage_path( 'app/' . $arquivo->path ) );
    }

    public function dowloadArquivo( $id ) {
        $arquivo = Arquivo::find( $id );
        return response()->download( storage_path( 'app/' . $arquivo->path ) );
    }

    public function upload( Request $request ) {
        // return $request;

        $caminho = new RepositorioController();

        $nome = $request->nome;
        $repositorio = $request->idRepositorio;
        $descricao = $request->descricao;
        $extensao = $request->file( 'file' )->extension();
        $size = $request->file( 'file' )->getClientSize();

        $path = $request->file( 'file' )->store( $caminho->caminho( $request->idRepositorio ) );

        $arquivo = Arquivo::create(
            [
                'nome' => $nome,
                'descricao' => $descricao,
                'extensao' => $extensao,
                'size' => $size,
                'path' => $path,
                'idRepositorio' => $repositorio,
                'idAutor' => auth()->user()->id
            ]
        );

        $nomeImagem = realpath( __DIR__ . '/../../../..' ) . '/storage/app/' . $path;

        if ( $extensao == 'pdf' ) {
            $im = new \Imagick();
            $im->setResolution( 300, 300 );
            $im->readimage( $nomeImagem );
            // Numero da pagina do arquivo .pdf
            $num_pages = $im->getNumberImages();
            for ( $i = 0; $i < $num_pages; $i++ ) {
                $im->setIteratorIndex( $i );
                $im->setImageFormat( 'jpeg' );
                $pathNovo = substr( $path, 0, -4 );
                $pathNovo = $pathNovo . '.jpeg';
                $salvaImagem = realpath( __DIR__ . '/../../../..' ) . '/storage/app/' . $pathNovo;
                $im->writeImage( $salvaImagem );
                // Nome da imagem que será criada

                $ocr = new TesseractOCR();
                $ocr->image( $salvaImagem );
                $ocr->lang( 'por' );
                $texto = $ocr->run();

                $busca = Busca::create(
                    [
                        'page' => $i,
                        'ocr' => $texto,
                        'idArquivo' => $arquivo->id
                    ]
                );
            }
            $im->clear();
            $im->destroy();
        } else {
            $ocr = new TesseractOCR();
            $ocr->image( $nomeImagem );
            $ocr->lang( 'por' );
            $texto = $ocr->run();

            $busca = Busca::create(
                [
                    'page' => 0,
                    'ocr' => $texto,
                    'idArquivo' => $arquivo->id
                ]
            );
        }

        return $arquivo;
    }

    public function update( Request $request, $id ) {

        if ( !empty( $request->file( 'filae' ) ) ) {
            // Excluir anterior
            $this->destroy( $id );

            // Add Novo com ocr
            $arquivo = $this->upload( $request );

            $arquivo->update( [
                'modificado' => $arquivo->modificado + 1,
            ] );

        } else {

            $arquivo = Arquivo::find( $id );

            $arquivo->update( [
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'modificado' => $arquivo->modificado + 1,
                'idAutor' => $request->idAutor,
                'idRepositorio' => $request->idRepositorio
            ] );

        }

        return 'Atualizado com Sucesso';
    }

    public function destroy( $id ) {
        $arquivo = Arquivo::find( $id );
        $path = $arquivo->path;

        Storage::delete( $path );

        if ( $arquivo->extensao == 'pdf' ) {
            $pathNovo = substr( $path, 0, -4 );
            $pathNovo = $pathNovo . '.jpeg';
            Storage::delete( $pathNovo );
        }

        DB::table( 'buscas' )->where( 'idArquivo', $arquivo->id )->delete();
        $arquivo->delete();
        return response()->json( 'Excluido com sucesso!' );
    }
}
