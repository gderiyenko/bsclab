<?php

namespace App\Providers;

use App\Models\Act;
use App\Models\Contract;
use App\Models\Firm;
use App\Models\Invoice;
use App\Models\Payment;
use App\Observers\ActObserver;
use App\Observers\ContractObserver;
use App\Observers\FirmObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Firm::observe(FirmObserver::class);
        Contract::observe(ContractObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
        Act::observe(ActObserver::class);
    }
}
