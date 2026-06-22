<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\JadwalModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class JadwalModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:JadwalModel');
    }

    public function view(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('View:JadwalModel');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:JadwalModel');
    }

    public function update(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('Update:JadwalModel');
    }

    public function delete(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('Delete:JadwalModel');
    }

    public function restore(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('Restore:JadwalModel');
    }

    public function forceDelete(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('ForceDelete:JadwalModel');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:JadwalModel');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:JadwalModel');
    }

    public function replicate(AuthUser $authUser, JadwalModel $jadwalModel): bool
    {
        return $authUser->can('Replicate:JadwalModel');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:JadwalModel');
    }

}