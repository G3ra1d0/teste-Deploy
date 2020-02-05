<?php

namespace App\Policies;

use App\Models\Repositorio;
use App\User;
use App\Models\Empresa;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositorioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any repositorios.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        
    }

    /**
     * Determine whether the user can view the repositorio.
     *
     * @param  \App\User  $user
     * @param  \App\Repositorio  $repositorio
     * @return mixed
     */
    public function view(User $user, Repositorio $repositorio)
    {
        if( $user->admin == 1 ){
            return true;
        }else{
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where('idResponsavel', $user->id )->get();
            if(!empty($empresas)){
                foreach($empresas as $emp){
                    if( $repositorio->idEmpresa ==  $emp['id'] ) return true;
                } 
                return false;
            }else{
                return false;
            }
        }
    }

    /**
     * Determine whether the user can create repositorios.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // return $user->admin == 1 || $empresa->idResponsavel == $user->id;

        if( $user->admin == 1 ){
            return true;
        }else{
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where('idResponsavel', $user->id )->get();
            if(!empty($empresas) && count($empresas) > 0){        
                return true;
            }
                
            return false;
        }
    }

    /**
     * Determine whether the user can update the repositorio.
     *
     * @param  \App\User  $user
     * @param  \App\Repositorio  $repositorio
     * @return mixed
     */
    public function update(User $user, Repositorio $repositorio)
    {
        if( $user->admin == 1 ){
            return true;
        }else{
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where('idResponsavel', $user->id )->get();
            if(!empty($empresas)){        
                foreach($empresas as $emp){
                        if($repositorio->idEmpresa ==  $emp['id'] ) return true;
                }
                return false;
            }else{
                return false;
            }
        }
    }

    /**
     * Determine whether the user can delete the repositorio.
     *
     * @param  \App\User  $user
     * @param  \App\Repositorio  $repositorio
     * @return mixed
     */
    public function delete(User $user, Repositorio $repositorio)
    {
        if( $user->admin == 1 ){
            return true;
        }else{
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where('idResponsavel', $user->id )->get();
            if(!empty($empresas)){        
                foreach($empresas as $emp){
                        if($repositorio->idEmpresa ==  $emp['id'] ) return true;
                }
                return false;
            }else{
                return false;
            }
        }
    }

    /**
     * Determine whether the user can restore the repositorio.
     *
     * @param  \App\User  $user
     * @param  \App\Repositorio  $repositorio
     * @return mixed
     */
    public function restore(User $user, Repositorio $repositorio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the repositorio.
     *
     * @param  \App\User  $user
     * @param  \App\Repositorio  $repositorio
     * @return mixed
     */
    public function forceDelete(User $user, Repositorio $repositorio)
    {
        //
    }
}
