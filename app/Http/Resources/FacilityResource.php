<?php

namespace App\Http\Resources;

use App\Models\FiscalDocument;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // FiscalDocument::where('type_document', 'facility')
        return
            [
                'creator' => $this->admin,
                'borrower' => $this->subscriber,
                'cheque' => $this->cheques,
                'cheque_sheet' => $this->cheque_sheets,
                'facility' =>
                [
                    'id'=>$this->id,
                    'uuid' => $this->uuid,
                    'code' => $this->code,
                    'title' => $this->title,
                    'amount_facility' => $this->amount_facility,
                    'wage' => $this->wage,
                    'receiver_date' => $this->receiver_date,
                    'quantity_installments' => $this->quantity_installments,
                    'amount_first_installment' => $this->amount_first_installment,
                    'amount_other_installment' => $this->amount_other_installment,
                    'payment_date' => $this->payment_date,
                    'fiscal_year' => $this->fiscal_year,
                    'fiscal_month' => $this->fiscal_month,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ],
                'installments'=> InstallmentBookletResource::collection($this->installment_booklet),
                //'fiscal_document' => $this
            ];
    }
}
