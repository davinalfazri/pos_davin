<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user, Penjualan $penjualan): bool
    {
       return $user->role->name === 'admin'
       && $penjualan->status === 'OPEN'; 
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa melihat seluruh transaksi (apapun statusnya).
        if ($user->role->name === 'admin') {
            return true;
        }

        // Kasir hanya bisa melihat transaksi miliknya sendiri.
        return $penjualan->user_id === $user->id;
    }
}

