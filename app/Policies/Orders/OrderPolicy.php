<?php

namespace App\Policies\Orders;

use App\Models\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return $user->isAdmin();
    }

    public function edit(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Order $order)
    {
        if($user->isAdmin()){
            return true;
        }

        return $user->id == $order->user_id;
    }
}
