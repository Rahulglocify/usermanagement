<?php

namespace App\Listeners;

use App\Events\NewUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
Use App\Models\User;
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
        $users = User::all();
    }
}
