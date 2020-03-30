<?php

namespace App\Imports;

use App\Models\AccountAssignment;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AccountAssignmentImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $account_assignment = AccountAssignment::where('code', $row[0])->first();

            if (empty($account_assignment)) {
                AccountAssignment::create([
                    'code' => $row[0],
                    'description' => $row[1],
                ]);
            }
        }
    }
}