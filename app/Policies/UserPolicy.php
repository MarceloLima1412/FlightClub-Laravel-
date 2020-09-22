<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if($user->direcao==1){
            return true;
        }

    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if($user->id == $model->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        if($user->direcao==1){
            return true;
        }

        return false;
    }

    public function reset(User $user)
    {
        if($user->direcao==1){
            return true;
        }

        return false;
    }


    public function ativar(User $user)
    {
        if($user->direcao==1){
            return true;
        }

        return false;
    }

    public function podeVerDocumentos(User $user, User $model)
    {   
        
        if($user->direcao==1 || $user->id == $model->id && $user->tipo_socio == 'P'){
            return true;
        }
        
        return false;
    }

    public function isAtivo(User $user)
    {
        if($user->ativo==0){
            return false;
        }

        return true;
    }

        public function direcaoOuPiloto(User $user)
    {   
        
        if($user->direcao==1 || $user->tipo_socio == 'P'){
            return true;
        }
        
        return false;
    }



/*
    public function isPiloto(User $user)
    {
        if($user->tipo_socio == 'P'){
            return true;
        }

        return false;
    }

    $user->direcao==1 || $user->tipo_socio=='P'
*/    
}
