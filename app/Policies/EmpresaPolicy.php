<?php

namespace App\Policies;

use App\Models\Empresa;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpresaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any empresas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->admin == 1; 
    }

    /**
     * Determine whether the user can view the empresa.
     *
     * @param  \App\User  $user
     * @param  \App\Empresa  $empresa
     * @return mixed
     */
    public function view(User $user, Empresa $empresa)
    {
        return $user->admin == 1 || $empresa->idResponsavel == $user->id;
    }

    /**
     * Determine whether the user can create empresas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin == 1;
    }

    /**
     * Determine whether the user can update the empresa.
     *
     * @param  \App\User  $user
     * @param  \App\Empresa  $empresa
     * @return mixed
     */
    public function update(User $user, Empresa $empresa)
    {
        return $user->admin == 1 || $empresa->idResponsavel == $user->id;
    }

    /**
     * Determine whether the user can delete the empresa.
     *
     * @param  \App\User  $user
     * @param  \App\Empresa  $empresa
     * @return mixed
     */
    public function delete(User $user, Empresa $empresa)
    {
        return $user->admin == 1;
    }

    /**
     * Determine whether the user can restore the empresa.
     *
     * @param  \App\User  $user
     * @param  \App\Empresa  $empresa
     * @return mixed
     */
    public function restore(User $user, Empresa $empresa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the empresa.
     *
     * @param  \App\User  $user
     * @param  \App\Empresa  $empresa
     * @return mixed
     */
    public function forceDelete(User $user, Empresa $empresa)
    {
        //
    }
}
