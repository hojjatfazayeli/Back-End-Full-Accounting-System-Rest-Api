<?php

namespace App\Http\Resources;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipRightReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $receipt =  Receipt::where('fiscal_document_id' , $this->id)->first();
        return
            [
                'creator' =>$this->admin,
                'fiscal_document' =>
                    [
                        'id'=>$this->id,
                        'uuid' => $this->uuid,
                        'nature_document' => $this->nature_document,
                        'type_document' => $this->type_document,
                        'title' => $this->title,
                        'description' => $this->description,
                        'document_date' => $this->document_date,
                        'serial_code' => $this->serial_code,
                        'payment_date' => $this->payment_date,
                        'fiscal_year' => $this->fiscal_year,
                        'fiscal_month' => $this->fiscal_month,
                        'status' => $this->status,
                        "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                        "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                    ],
                'fiscal_document_item' =>$this->fiscal_document_item()->where('account_id' , '56')->first(),
                'cheque'=>$this->cheque,
                'cheque_sheet' => $this->cheque_sheet,
                'receipt'=>new ReceiptInfoResource($receipt)
            ];
    }
}

