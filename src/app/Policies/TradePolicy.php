<?php

namespace App\Policies;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TradePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trade $trade): bool
    {
        // 取引に関わるユーザー（購入者または出品者）のみ許可
        return $user->id === $trade->buyer_id || $user->id === $trade->seller_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trade $trade): bool
    {
        // 取引の購入者のみ更新（完了）を許可
        return $user->id === $trade->buyer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trade $trade)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trade $trade)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trade $trade)
    {
        //
    }
}
