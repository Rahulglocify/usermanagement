<?php

namespace App\Providers;

use App\Providers\NewUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GetNewRegistredUsers
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
     * @param  NewUsers  $event
     * @return void
     */
    public function handle(NewUsers $event)
    {
        //
    }
}
