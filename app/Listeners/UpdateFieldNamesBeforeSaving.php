<?php

namespace App\Listeners;

use App\Events\GeneralPaymentDataSaving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateFieldNamesBeforeSaving
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
     * @param  GeneralPaymentDataSaving  $event
     * @return void
     */
    public function handle(GeneralPaymentDataSaving $event)
    {
        //
    }
}
