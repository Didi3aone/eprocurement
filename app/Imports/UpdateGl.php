<?php

namespace App\Imports;

use App\Models\MasterUnit;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UpdateGl implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row ) {
            // dd($preq);
            $pr = \App\Models\PurchaseRequest::where('PR_NO', $row[0])->first();

            $glUpdate = \App\Models\PurchaseRequestsDetail::where('request_id', $pr->id)
                    ->first();
            // dd($glUpdate);
            
            $glUpdate->gl_acct_code =  $row[1];
            $glUpdate->update();
        }
    }
}