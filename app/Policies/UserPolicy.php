<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Empresa;

class UserPolicy {
    use HandlesAuthorization;

    /**
    * Determine whether the user can view any models.
    *
    * @param  \App\User  $user
    * @return mixed
    */

    public function viewAny( User $user ) {
        if ( $user->admin == 1 ) {
            return true;
        } else {
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where( 'idResponsavel', $user->id )->get();
            if ( !empty( $empresas ) ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
    * Determine whether the user can view the model.
    *
    * @param  \App\User  $user
    * @param  \App\User  $model
    * @return mixed
    */

    public function view( User $user, User $model ) {
        if ( $user->admin == 1 || $model->id == $user->id ) {
            return true;
        } else {
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where( 'idResponsavel', $user->id )->get();
            if ( !empty( $empresas ) ) {
                $grupos = $model->Grupos;
                foreach ( $grupos as $value ) {
                    foreach ( $empresas as $emp ) {
                        if ( $value['idEmpresa'] ==  $emp['id'] ) return true;
                    }
                }
                return false;
            } else {
                return false;
            }
        }
    }

    /**
    * Determine whether the user can create models.
    *
    * @param  \App\User  $user
    * @return mixed
    */

    public function create( User $user ) {
        // return $user->admin == 1;
        if ( $user->admin == 1 ) {
            return true;
        } else {
            // Verefico se o usuario que quer acessa e responsavel de alguma empresa
            $empresas = Empresa::where( 'idResponsavel', $user->id )->get();
            if ( !empty( $empresas ) ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
    * Determine whether the user can update the model.
    *
    * @param  \App\User  $user
    * @param  \App\User  $model
    * @return mixed
    */

    public function update( User $user, User $model ) {
        return $user->admin == 1;
    }

    /**
    * Determine whether the user can delete the model.
    *
    * @param  \App\User  $user
    * @param  \App\User  $model
    * @return mixed
    */

    public function delete( User $user, User $model ) {
        return $user->admin == 1;
    }

    /**
    * Determine whether the user can restore the model.
    *
    * @param  \App\User  $user
    * @param  \App\User  $model
    * @return mixed
    */

    public function restore( User $user, User $model ) {
        //
    }

    /**
    * Determine whether the user can permanently delete the model.
    *
    * @param  \App\User  $user
    * @param  \App\User  $model
    * @return mixed
    */

    public function forceDelete( User $user, User $model ) {
        //
    }
}
