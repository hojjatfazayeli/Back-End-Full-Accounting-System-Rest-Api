<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\AccountGroupe;
use App\Models\AccountSubScriber;
use App\Models\Admin;
use App\Models\Cheque;
use App\Models\ChequeSheet;
use App\Models\Facilities;
use App\Models\FamilySubScriber;
use App\Models\FiscalDocument;
use App\Models\FiscalDocumentItem;
use App\Models\FiscalTransaction;
use App\Models\FiscalYear;
use App\Models\FiscalYearsItem;
use App\Models\InstallmentBooklet;
use App\Models\Message;
use App\Models\MessageBox;
use App\Models\Notification;
use App\Models\PaymentInstallment;
use App\Models\Receipt;
use App\Models\SubScriber;
use App\Observers\AccountGroupeObserer;
use App\Observers\AccountObserver;
use App\Observers\AccountSubScriberObserver;
use App\Observers\AdminObserver;
use App\Observers\ChequeObserver;
use App\Observers\ChequeSheetObserver;
use App\Observers\FacilitiesObserver;
use App\Observers\FamilySubScriberObserver;
use App\Observers\FiscalDocumentItemObserver;
use App\Observers\FiscalDocumentObserver;
use App\Observers\FiscalTransactionObserver;
use App\Observers\FiscalYearObserver;
use App\Observers\FiscalYearsItemObserver;
use App\Observers\InstallmentBookletObserver;
use App\Observers\MessageBoxObserver;
use App\Observers\MessageObserver;
use App\Observers\NotificationObserver;
use App\Observers\PaymentInstallmentObserver;
use App\Observers\ReceiptObserver;
use App\Observers\SubScriberObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Admin::observe(AdminObserver::class);
        AccountGroupe::observe(AccountGroupeObserer::class);
        Account::observe(AccountObserver::class);
        Cheque::observe(ChequeObserver::class);
        ChequeSheet::observe(ChequeSheetObserver::class);
        SubScriber::observe(SubScriberObserver::class);
        FamilySubScriber::observe(FamilySubScriberObserver::class);
        FiscalYear::observe(FiscalYearObserver::class);
        FiscalYearsItem::observe(FiscalYearsItemObserver::class);
        Facilities::observe(FacilitiesObserver::class);
        InstallmentBooklet::observe(InstallmentBookletObserver::class);
        PaymentInstallment::observe(PaymentInstallmentObserver::class);
        FiscalDocument::observe(FiscalDocumentObserver::class);
        FiscalDocumentItem::observe(FiscalDocumentItemObserver::class);
        AccountSubScriber::observe(AccountSubScriberObserver::class);
        MessageBox::observe(MessageBoxObserver::class);
        Message::observe(MessageObserver::class);
        Receipt::observe(ReceiptObserver::class);
        FiscalTransaction::observe(FiscalTransactionObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
