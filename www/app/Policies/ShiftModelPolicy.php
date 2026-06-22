<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ShiftModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ShiftModel');
    }

    public function view(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('View:ShiftModel');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ShiftModel');
    }

    public function update(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('Update:ShiftModel');
    }

    public function delete(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('Delete:ShiftModel');
    }

    public function restore(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('Restore:ShiftModel');
    }

    public function forceDelete(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('ForceDelete:ShiftModel');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ShiftModel');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ShiftModel');
    }

    public function replicate(AuthUser $authUser, ShiftModel $shiftModel): bool
    {
        return $authUser->can('Replicate:ShiftModel');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ShiftModel');
    }

}