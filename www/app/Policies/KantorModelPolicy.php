<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KantorModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class KantorModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KantorModel');
    }

    public function view(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('View:KantorModel');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KantorModel');
    }

    public function update(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('Update:KantorModel');
    }

    public function delete(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('Delete:KantorModel');
    }

    public function restore(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('Restore:KantorModel');
    }

    public function forceDelete(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('ForceDelete:KantorModel');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KantorModel');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KantorModel');
    }

    public function replicate(AuthUser $authUser, KantorModel $kantorModel): bool
    {
        return $authUser->can('Replicate:KantorModel');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KantorModel');
    }

}