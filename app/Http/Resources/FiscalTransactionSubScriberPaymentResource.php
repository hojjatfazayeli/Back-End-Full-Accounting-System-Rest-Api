<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalTransactionSubScriberPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $membership_right = $this->fiscal_transaction()->where('type' , 'membershipـright')->where('fiscal_year',$request->fiscal_year)->where('fiscal_month' , $request->fiscal_month)->first();
        $motivational = $this->fiscal_transaction()->where('type' , 'motivational')->where('fiscal_year',$request->fiscal_year)->where('fiscal_month' , $request->fiscal_month)->first();
        $participate_right = $this->fiscal_transaction()->where('type' , 'participate_right')->where('fiscal_year',$request->fiscal_year)->where('fiscal_month' , $request->fiscal_month)->first();
        $installment =   $this->payment_installment()->where('fiscal_year' , $request->fiscal_year)->where('fiscal_month' , $request->fiscal_month)->first();

        if ($membership_right)
        {
            $membership_right =
                [
                    'id'=>$membership_right->id,
                    'uuid'=>$membership_right->uuid,
                    'payment_type'=>$membership_right->payment_type,
                    'fiscal_year'=>$membership_right->fiscal_year,
                    'fiscal_month'=>$membership_right->fiscal_month,
                    'payment_date'=>$membership_right->payment_date,
                    'payment_amount'=>$membership_right->payment_amount,
                    'payment_tracking_code'=>$membership_right->payment_tracking_code,
                    'card_number'=>$membership_right->card_number,
                    'file'=>env('APP_STORAGE').'/'.$membership_right->file,
                    'description'=>$membership_right->description,
                    'bank'=>$membership_right->bank,
                    'checker'=>$membership_right->admin,
                    'status'=>$membership_right->status,
                    "created_at"=>$membership_right->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$membership_right->updated_at->format('Y-m-d - H:i:s')
                ];
        }
        else
        {$membership_right = null;}
        if ($motivational)
        {
            $motivational =
                [
                    'id'=>$motivational->id,
                    'uuid'=>$motivational->uuid,
                    'payment_type'=>$motivational->payment_type,
                    'fiscal_year'=>$motivational->fiscal_year,
                    'fiscal_month'=>$motivational->fiscal_month,
                    'payment_date'=>$motivational->payment_date,
                    'payment_amount'=>$motivational->payment_amount,
                    'payment_tracking_code'=>$motivational->payment_tracking_code,
                    'card_number'=>$motivational->card_number,
                    'file'=>env('APP_STORAGE').'/'.$motivational->file,
                    'description'=>$motivational->description,
                    'bank'=>$motivational->bank,
                    'checker'=>$motivational->admin,
                    'status'=>$motivational->status,
                    "created_at"=>$motivational->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$motivational->updated_at->format('Y-m-d - H:i:s')
                ];
        }
        else
        {$motivational = null;}
        if ($participate_right)
        {
            $participate_right =
                [
                    'id'=>$participate_right->id,
                    'uuid'=>$participate_right->uuid,
                    'payment_type'=>$participate_right->payment_type,
                    'fiscal_year'=>$participate_right->fiscal_year,
                    'fiscal_month'=>$participate_right->fiscal_month,
                    'payment_date'=>$participate_right->payment_date,
                    'payment_amount'=>$participate_right->payment_amount,
                    'payment_tracking_code'=>$participate_right->payment_tracking_code,
                    'card_number'=>$participate_right->card_number,
                    'file'=>env('APP_STORAGE').'/'.$participate_right->file,
                    'description'=>$participate_right->description,
                    'bank'=>$participate_right->bank,
                    'checker'=>$participate_right->admin,
                    'status'=>$participate_right->status,
                    "created_at"=>$participate_right->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$participate_right->updated_at->format('Y-m-d - H:i:s')
                ];
        }
        else
        {$participate_right = null;}
        if ($installment)
        {
            $installment =
                [
                    'id'=>$installment->id,
                    'uuid'=>$installment->uuid,
                    'payment_type'=>$installment->payment_type,
                    'fiscal_year'=>$installment->fiscal_year,
                    'fiscal_month'=>$installment->fiscal_month,
                    'payment_date'=>$installment->payment_date,
                    'payment_amount'=>$installment->payment_amount,
                    'payment_tracking_code'=>$installment->payment_tracking_code,
                    'card_number'=>$installment->card_number,
                    'file'=>env('APP_STORAGE').'/'.$installment->file,
                    'description'=>$installment->description,
                    'bank'=>$installment->bank,
                    'checker'=>$installment->admin,
                    'status'=>$installment->status,
                    "created_at"=>$installment->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$installment->updated_at->format('Y-m-d - H:i:s'),
                    'facility' => $installment->facility,
                    'installment_booklet' => $installment->installment_booklet,
                ];
        }
        else
        {$installment = null;}
        return
            [
                'membershipـright' => $membership_right,
                'motivational' => $motivational,
                'participate_right' => $participate_right,
                'payment_installment' => $installment
            ];
    }
}
