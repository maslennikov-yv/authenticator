<?php

namespace Maslennikov\Authorizator\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Maslennikov\Authorizator\Contracts\HasRole;
use Maslennikov\Authorizator\Facade\Authorizator;
use Maslennikov\Authorizator\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param HasRole $user
     * @return Response|bool
     */
    public function viewAny(HasRole $user): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param HasRole $user
     * @param Role $role
     * @return Response|bool
     */
    public function view(HasRole $user, Role $role): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param HasRole $user
     * @return Response|bool
     */
    public function create(HasRole $user): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param HasRole $user
     * @param Role $role
     * @return Response|bool
     */
    public function update(HasRole $user, Role $role): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param HasRole $user
     * @param Role $role
     * @return Response|bool
     */
    public function delete(HasRole $user, Role $role): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param HasRole $user
     * @param Role $role
     * @return Response|bool
     */
    public function restore(HasRole $user, Role $role): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param HasRole $user
     * @param Role $role
     * @return Response|bool
     */
    public function forceDelete(HasRole $user, Role $role): Response|bool
    {
        return Authorizator::hasPermission($user->getRole(), 'roles.forceDelete');
    }
}
