<?php

namespace App\Http\Resources;

use App\Models\FiscalYearsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalTransactionSubScriberStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $monthly_subscription = 0;
        $participationـrights = 0;
        $motivational = 0;
        $fiscal_year_item = FiscalYearsItem::where('status' , 'active')->first();
        $this->avatar !=null ? $avatar = env('APP_STORAGE').'/'.$this->avatar : $avatar=Null;
        $this->monthly_subscription == 'active' ? $monthly_subscription = $fiscal_year_item->amount_membershipـright_month * $this->status_portion : $monthly_subscription = 0;
        $this->participationـrights == 'active' ? $participationـrights = $fiscal_year_item->amount_participate_right : $participationـrights = 0;
        $this->motivational == 'active' ? $motivational = $fiscal_year_item->amount_motivational : $motivational = 0;
        $installment =   $this->installment_booklet()->where('payment_year' , $request->fiscal_year)->where('payment_month' , $request->fiscal_month)->first();

        if ($installment)
        {
            $installment_item =
                [
                    'id' => $installment->id,
                    'facility_code' => $installment->facility->code,
                    'remaining_number_installment' => count($this->installment_booklet()->where('status' , 'unpaid')->get()),
                    'paid_number_installment' => count($this->installment_booklet()->where('status' , 'paid')->get()),
                    'sum_paid_installment' => $this->installment_booklet()->where('status' , 'paid')->sum('amount_installment'),
                    'sum_unpaid_installment' => $this->installment_booklet()->where('status' , 'unpaid')->sum('amount_installment'),
                    'creator' => $installment->admin->firstname .' '. $installment->admin->lastname,
                    'type_installment' => $installment->type_installment,
                    'payment_date' => $installment->payment_date,
                    'payment_year' => $installment->payment_year,
                    'payment_month' => $installment->payment_month,
                    'amount_installment' =>$installment->amount_installment,
                    'status'=>$installment->status,
                    "created_at"=>$installment->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$installment->updated_at->format('Y-m-d - H:i:s'),
                ];
            $amount_insallment = $installment->amount_installment;

        }
        else
        {
            $installment_item = null;
            $amount_insallment = 0;

        }
        return
            [
                'subscriber' =>
                    [
                        'id'=>$this->id,
                        'fullname' => $this->firstname.' '.$this->lastname,
                        'status_employee' => $this->status_employee,
                        'nationalcode' => $this->nationalcode,
                        'fiscal_year' => $request->fiscal_year,
                        'fiscal_month' => $request->fiscal_month,
                        'monthly_subscription' => $monthly_subscription,
                        'participationـrights' => $participationـrights,
                        'motivational' => $motivational,
                        'total_payable' => $monthly_subscription + $participationـrights + $motivational + $amount_insallment,
                        'avatar' =>$avatar
                    ],
                'installment' =>$installment_item

            ];
    }
}
