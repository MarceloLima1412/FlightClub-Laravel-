<?php

namespace App\Policies;

use App\User;
use App\Movimento;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovimentoPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){


    }

    /**
     * Determine whether the user can view the movimento.
     *
     * @param  \App\User  $user
     * @param  \App\Movimento  $movimento
     * @return mixed
     */
    public function view(User $user, Movimento $movimento)
    {
        return true;
    }

    public function viewAll(User $user)
    {
        if($user->direcao==1){
            return true;
        }
        return false;
    }

    public function pesquisar(User $user)
    {
        if($user->tipo_socio=='P'){
            return true;
        }
        return false;
    }

    /**
     *
     * Determine whether the user can create movimentos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->direcao==1 || $user->tipo_socio=='P'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the movimento.
     *
     * @param  \App\User  $user
     * @param  \App\Movimento  $movimento
     * @return mixed
     */
    public function update(User $user, Movimento $movimento)
    {
  
        if($movimento->confirmado){
            return false;
        }
        if($user->direcao==1){
            return true;
        }
       if($user->id == $movimento->piloto_id || $user->id == $movimento->instrutor_id){
           return true;
       }
        return false;
    }

    /**
     * Determine whether the user can delete the movimento.
     *
     * @param  \App\User  $user
     * @param  \App\Movimento  $movimento
     * @return mixed
     */
    public function delete(User $user, Movimento $movimento)
    {
        if($movimento->confirmado){
            return false;
        }
        if($user->direcao==1){
            return true;
        }
        if($user->id == $movimento->piloto_id || $user->id == $movimento->instrutor_id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the movimento.
     *
     * @param  \App\User  $user
     * @param  \App\Movimento  $movimento
     * @return mixed
     */
    public function restore(User $user, Movimento $movimento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the movimento.
     *
     * @param  \App\User  $user
     * @param  \App\Movimento  $movimento
     * @return mixed
     */
    public function forceDelete(User $user, Movimento $movimento)
    {
        //
    }

    public function confirmar(User $user, Movimento $movimento)
    {

        if($movimento->confirmado == 1){
            return false;
        }
        if($user->direcao==1){
            return true;
        }

        return false;
    }
}
