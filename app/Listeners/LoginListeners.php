<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use App\Model\Admin;
use App\Model\AdminInfo;
use Session;
use App\Tools\Loader;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListeners
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
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        Session::put('admin',$event->adminSessionData);

        /* @var AdminInfo $adminInfo */
        $adminInfo = Loader::singleton(AdminInfo::class);
        $adminInfo->updateLoginInfo($event->userId,$event->ip,$event->loginTime);
    }
}
