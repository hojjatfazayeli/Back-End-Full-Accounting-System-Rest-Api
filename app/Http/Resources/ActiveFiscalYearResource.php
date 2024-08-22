<?php

namespace App\Http\Resources;

use App\Models\FiscalYearsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveFiscalYearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $active_fiscal_year_item = FiscalYearsItem::where('fiscal_year_id',$this->id)->where('status','active')->first();

        return
            [
                'active_fiscal_year' =>
                    [
                        'id' => $this->id,
                        'year' => $this->year,
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                    ],
                'active_fiscal_year_item' =>
                    [
                        'id' => $active_fiscal_year_item->id,
                        'amount_membershipـright_month' => $active_fiscal_year_item->amount_membershipـright_month,
                        'amount_participate_right' => $active_fiscal_year_item->amount_participate_right,
                        'amount_membership_fee' => $active_fiscal_year_item->amount_membership_fee,
                        'amount_motivational' => $active_fiscal_year_item->amount_motivational,
                        'fee_percentage' => $active_fiscal_year_item->fee_percentage,
                    ]
            ];
    }
}
