<?php

namespace App\Listeners;

use App\Events\SendMsg;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMsgListener
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
     * @param  SendMsg  $event
     * @return void
     */
    public function handle(SendMsg $event)
    {
        //
    }
}
