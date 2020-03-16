<?php

namespace App\Imports;

use App\Models\Gl;
use Maatwebsite\Excel\Concerns\ToModel;

class GlsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        return new Gl([
            'code' => $row[0],
            'account' => $row[1],
            'balance' => $row[2],
            'short_text' => $row[4],
            'acct_long_text' => $row[5],
            'long_text' => $row[6],
        ]);
    }
}
