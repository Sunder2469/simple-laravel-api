<?php

namespace App\Listeners;

use App\Events\TransactionAdded;
use Illuminate\Queue\InteractsWithQueue;

class NotifyTransactionAdded
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionAdded $event): void
    {
        // code for notify frontend
    }
}
