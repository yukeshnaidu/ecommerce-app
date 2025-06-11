<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\CartController;

class MergeGuestCartWithUserCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
      public function handle(Login $event)
    {
        $cartController = new CartController();
        $cartController->mergeGuestCartWithUserCart($event->user->id);
    }
}
