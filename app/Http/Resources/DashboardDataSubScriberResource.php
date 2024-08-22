<?php

namespace App\Http\Resources;

use App\Models\Facilities;
use App\Models\FiscalYearsItem;
use App\Models\Message;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardDataSubScriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $active_fiscal_year_item = FiscalYearsItem::where('status' , 'active')->first();
        $facilities = Facilities::query();
        $active_facility = Facilities::where('status' , 'active')->first();
        $last_notify = Message::where('receiver_role' , 'subscriber')->where('receiver_id' , $this->id)->limit(5)->get();
        return
            [
                'info' => new SubScriberInfoResource(SubScriber::find($this->id)),
                'active_fiscal_year' => new FiscalYearItemInfoResource($active_fiscal_year_item),
                'facilities' =>
                [
                    'received_facility' =>
                    [
                        'count' => count($facilities->where('status' , 'deactive')->get()),
                        'total_amount' => $facilities->where('status' , 'deactive')->sum('amount_facility')
                    ],
                    'current_facility' =>
                    [
                        'count' => 1,
                        'total_amount' => $active_facility->amount_facility,
                        'payment_installment' =>
                        [
                            'count' => count($active_facility->installment_booklet()->where('status' , 'paid')->get()),
                            'total_amount' => $active_facility->installment_booklet()->where('status' , 'paid')->sum('amount_installment'),
                        ],
                        'remaining_installment' =>
                        [
                            'count' => count($active_facility->installment_booklet()->where('status' , 'unpaid')->get()),
                            'total_amount' => $active_facility->installment_booklet()->where('status' , 'unpaid')->sum('amount_installment'),
                        ]
                    ]
                ],
                'last_payment' =>
                    [
                        'initial_membership' => $this->fiscal_transaction()->where('type' , 'initial_membership_fee')->orderby('created_at' , 'desc')->first(),
                        'membershipـright' => $this->fiscal_transaction()->where('type' , 'membershipـright')->orderby('created_at' , 'desc')->first(),
                        'participate_right' => $this->fiscal_transaction()->where('type' , 'participate_right')->orderby('created_at' , 'desc')->first(),
                        'motivational' => $this->fiscal_transaction()->where('type' , 'motivational')->orderby('created_at' , 'desc')->first(),
                    ],
                'last_receipt' => new ChequeSheetResource($active_facility->cheque_sheets),
                'chart' =>
                [
                        'total_payment' =>$this->fiscal_transaction()->sum('payment_amount'),
                        'total_payment_initial_membership' => $this->fiscal_transaction()->where('type' , 'initial_membership_fee')->sum('payment_amount'),
                        'total_payment_membershipـright' => $this->fiscal_transaction()->where('type' , 'membershipـright')->sum('payment_amount'),
                        'total_payment_participate_right' => $this->fiscal_transaction()->where('type' , 'participate_right')->sum('payment_amount'),
                        'total_payment_motivational' => $this->fiscal_transaction()->where('type' , 'motivational')->sum('payment_amount'),
                ],
                'last_broadcast_notify_list' => MessageInfoResource::collection($last_notify)
            ];
    }
}
