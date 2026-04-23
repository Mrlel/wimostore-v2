<?php

// app/Policies/CabinePagePolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\CabinePage;

class CabinePagePolicy
{
    public function update(User $user, CabinePage $page): bool
    {
        // Admin peut tout faire
        if (($user->role ?? null) === 'superadmin') {
            return true;
        }
        // Sinon, uniquement si la page appartient à sa cabine
        return $user->cabine_id === $page->cabine_id;
    }

    public function delete(User $user, CabinePage $page): bool
    {
        if (($user->role ?? null) === 'superadmin') {
            return true;
        }
        return $user->cabine_id === $page->cabine_id;
    }
}
