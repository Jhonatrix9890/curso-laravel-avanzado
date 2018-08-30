<?php

namespace App\Policies;

use App\User;
use App\Pelicula;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeliculaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the pelicula.
     *
     * @param  \App\User  $user
     * @param  \App\Pelicula  $pelicula
     * @return mixed
     */
    public function view(User $user, Pelicula $pelicula)
    {
        return true;
    }

    /**
     * Determine whether the user can create peliculas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the pelicula.
     *
     * @param  \App\User  $user
     * @param  \App\Pelicula  $pelicula
     * @return mixed
     */
    public function update(User $user, Pelicula $pelicula)
    {
        return $user->id==$pelicula->idUser;
    }

    /**
     * Determine whether the user can delete the pelicula.
     *
     * @param  \App\User  $user
     * @param  \App\Pelicula  $pelicula
     * @return mixed
     */
    public function delete(User $user, Pelicula $pelicula)
    {
        return $user->id==$pelicula->idUser;
    }

    /**
     * Determine whether the user can restore the pelicula.
     *
     * @param  \App\User  $user
     * @param  \App\Pelicula  $pelicula
     * @return mixed
     */
    public function restore(User $user, Pelicula $pelicula)
    {
        return $user->id==$pelicula->idUser;
    }

    /**
     * Determine whether the user can permanently delete the pelicula.
     *
     * @param  \App\User  $user
     * @param  \App\Pelicula  $pelicula
     * @return mixed
     */
    public function forceDelete(User $user, Pelicula $pelicula)
    {
        return $user->id==$pelicula->idUser;
    }
}
