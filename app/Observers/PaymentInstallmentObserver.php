<?php

namespace App\Observers;

use App\Models\PaymentInstallment;
use Illuminate\Support\Facades\Auth;

class PaymentInstallmentObserver
{
    public function creating(PaymentInstallment $paymentInstallment):void
    {
        $paymentInstallment->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        if ($paymentInstallment->status == 'accepted' or $paymentInstallment->status == 'rejected')
        {
            $paymentInstallment->checker_id = Auth::user()->id;
        }
    }
    /**
     * Handle the PaymentInstallment "created" event.
     */
    public function created(PaymentInstallment $paymentInstallment): void
    {
        if ($paymentInstallment->status == 'accepted' or $paymentInstallment->status == 'rejected')
        {
            $paymentInstallment->installment_booklet()->update(['status' => 'paid']);
        }
    }

    /**
     * Handle the PaymentInstallment "updated" event.
     */
    public function updated(PaymentInstallment $paymentInstallment): void
    {
        if ($paymentInstallment->status == 'accepted' or $paymentInstallment->status == 'rejected')
        {
            $paymentInstallment->checker_id = Auth::user()->id;
            $paymentInstallment->installment_booklet()->update(['status' => 'paid']);
        }
    }

    /**
     * Handle the PaymentInstallment "deleted" event.
     */
    public function deleted(PaymentInstallment $paymentInstallment): void
    {
        //
    }

    /**
     * Handle the PaymentInstallment "restored" event.
     */
    public function restored(PaymentInstallment $paymentInstallment): void
    {
        //
    }

    /**
     * Handle the PaymentInstallment "force deleted" event.
     */
    public function forceDeleted(PaymentInstallment $paymentInstallment): void
    {
        //
    }
}
