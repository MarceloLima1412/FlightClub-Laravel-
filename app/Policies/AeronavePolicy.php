<?php

namespace App\Policies;

use App\User;
use App\Aeronave;
use Illuminate\Auth\Access\HandlesAuthorization;

class AeronavePolicy
{
    use HandlesAuthorization;


    public function before($user, $ability){
        if($user->direcao==1){
            return true;
        }

    }
    /**
     * Determine whether the user can view the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function view(User $user, Aeronave $aeronave)
    {
        return true;
    }

    /**
     * Determine whether the user can create aeronaves.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function update(User $user, Aeronave $aeronave)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function delete(User $user, Aeronave $aeronave)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function restore(User $user, Aeronave $aeronave)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function forceDelete(User $user, Aeronave $aeronave)
    {
        //
    }
}
