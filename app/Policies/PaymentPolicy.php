<?php

namespace App\Policies;

use App\User;
use App\Models\Versement;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any versements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the versement.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Versement  $versement
     * @return mixed
     */
    public function view(User $user, Versement $versement)
    {
        //
    }

    /**
     * Determine whether the user can create versements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the versement.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Versement  $versement
     * @return mixed
     */
    public function update(User $user, Versement $versement)
    {
        //
    }

    /**
     * Determine whether the user can delete the versement.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Versement  $versement
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role_id === 1 || $user->role_id === 2;
    }

    /**
     * Determine whether the user can restore the versement.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Versement  $versement
     * @return mixed
     */
    public function restore(User $user, Versement $versement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the versement.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Versement  $versement
     * @return mixed
     */
    public function forceDelete(User $user, Versement $versement)
    {
        //
    }
}
