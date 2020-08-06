<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\MasterVendorTermsOfPayment;

class UpdateMasterVendorTermsOfPayment20200806183700 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['code' => 'Z000', 'number_of_days' => 0, 'description' => 'Cash'],
            ['code' => 'Z001', 'number_of_days' => 1, 'description' => '01 Days Credit'],
            ['code' => 'Z002', 'number_of_days' => 2, 'description' => '02 Days Credit'],
            ['code' => 'Z003', 'number_of_days' => 3, 'description' => '03 Days Credit'],
            ['code' => 'Z004', 'number_of_days' => 4, 'description' => '04 Days Credit'],
            ['code' => 'Z005', 'number_of_days' => 5, 'description' => '05 Days Credit'],
            ['code' => 'Z006', 'number_of_days' => 6, 'description' => '06 Days Credit'],
            ['code' => 'Z007', 'number_of_days' => 7, 'description' => '07 Days Credit'],
            ['code' => 'Z008', 'number_of_days' => 8, 'description' => '08 Days Credit'],
            ['code' => 'Z009', 'number_of_days' => 9, 'description' => '09 Days Credit'],
            ['code' => 'Z010', 'number_of_days' => 10, 'description' => '10 Days Credit'],
            ['code' => 'Z011', 'number_of_days' => 11, 'description' => '11 Days Credit'],
            ['code' => 'Z012', 'number_of_days' => 12, 'description' => '12 Days Credit'],
            ['code' => 'Z013', 'number_of_days' => 13, 'description' => '13 Days Credit'],
            ['code' => 'Z014', 'number_of_days' => 14, 'description' => '14 Days Credit'],
            ['code' => 'Z015', 'number_of_days' => 15, 'description' => '15 Days Credit'],
            ['code' => 'Z016', 'number_of_days' => 16, 'description' => '16 Days Credit'],
            ['code' => 'Z017', 'number_of_days' => 17, 'description' => '17 Days Credit'],
            ['code' => 'Z018', 'number_of_days' => 18, 'description' => '18 Days Credit'],
            ['code' => 'Z019', 'number_of_days' => 19, 'description' => '19 Days Credit'],
            ['code' => 'Z020', 'number_of_days' => 20, 'description' => '20 Days Credit'],
            ['code' => 'Z021', 'number_of_days' => 21, 'description' => '21 Days Credit'],
            ['code' => 'Z022', 'number_of_days' => 22, 'description' => '22 Days Credit'],
            ['code' => 'Z023', 'number_of_days' => 23, 'description' => '23 Days Credit'],
            ['code' => 'Z024', 'number_of_days' => 24, 'description' => '24 Days Credit'],
            ['code' => 'Z025', 'number_of_days' => 25, 'description' => '25 Days Credit'],
            ['code' => 'Z026', 'number_of_days' => 26, 'description' => '26 Days Credit'],
            ['code' => 'Z027', 'number_of_days' => 27, 'description' => '27 Days Credit'],
            ['code' => 'Z028', 'number_of_days' => 28, 'description' => '28 Days Credit'],
            ['code' => 'Z029', 'number_of_days' => 29, 'description' => '29 Days Credit'],
            ['code' => 'Z030', 'number_of_days' => 30, 'description' => '30 Days Credit'],
            ['code' => 'Z031', 'number_of_days' => 31, 'description' => '31 Days Credit'],
            ['code' => 'Z032', 'number_of_days' => 32, 'description' => '32 Days Credit'],
            ['code' => 'Z033', 'number_of_days' => 33, 'description' => '33 Days Credit'],
            ['code' => 'Z034', 'number_of_days' => 34, 'description' => '34 Days Credit'],
            ['code' => 'Z035', 'number_of_days' => 35, 'description' => '35 Days Credit'],
            ['code' => 'Z036', 'number_of_days' => 36, 'description' => '36 Days Credit'],
            ['code' => 'Z037', 'number_of_days' => 37, 'description' => '37 Days Credit'],
            ['code' => 'Z038', 'number_of_days' => 38, 'description' => '38 Days Credit'],
            ['code' => 'Z039', 'number_of_days' => 39, 'description' => '39 Days Credit'],
            ['code' => 'Z040', 'number_of_days' => 40, 'description' => '40 Days Credit'],
            ['code' => 'Z041', 'number_of_days' => 41, 'description' => '41 Days Credit'],
            ['code' => 'Z042', 'number_of_days' => 42, 'description' => '42 Days Credit'],
            ['code' => 'Z043', 'number_of_days' => 43, 'description' => '43 Days Credit'],
            ['code' => 'Z044', 'number_of_days' => 44, 'description' => '44 Days Credit'],
            ['code' => 'Z045', 'number_of_days' => 45, 'description' => '45 Days Credit'],
            ['code' => 'Z046', 'number_of_days' => 46, 'description' => '46 Days Credit'],
            ['code' => 'Z047', 'number_of_days' => 47, 'description' => '47 Days Credit'],
            ['code' => 'Z048', 'number_of_days' => 48, 'description' => '48 Days Credit'],
            ['code' => 'Z049', 'number_of_days' => 49, 'description' => '49 Days Credit'],
            ['code' => 'Z050', 'number_of_days' => 50, 'description' => '50 Days Credit'],
            ['code' => 'Z051', 'number_of_days' => 51, 'description' => '51 Days Credit'],
            ['code' => 'Z052', 'number_of_days' => 52, 'description' => '52 Days Credit'],
            ['code' => 'Z053', 'number_of_days' => 53, 'description' => '53 Days Credit'],
            ['code' => 'Z054', 'number_of_days' => 54, 'description' => '54 Days Credit'],
            ['code' => 'Z055', 'number_of_days' => 55, 'description' => '55 Days Credit'],
            ['code' => 'Z056', 'number_of_days' => 56, 'description' => '56 Days Credit'],
            ['code' => 'Z057', 'number_of_days' => 57, 'description' => '57 Days Credit'],
            ['code' => 'Z058', 'number_of_days' => 58, 'description' => '58 Days Credit'],
            ['code' => 'Z059', 'number_of_days' => 59, 'description' => '59 Days Credit'],
            ['code' => 'Z060', 'number_of_days' => 60, 'description' => '60 Days Credit'],
            ['code' => 'Z061', 'number_of_days' => 61, 'description' => '61 Days Credit'],
            ['code' => 'Z062', 'number_of_days' => 62, 'description' => '62 Days Credit'],
            ['code' => 'Z063', 'number_of_days' => 63, 'description' => '63 Days Credit'],
            ['code' => 'Z064', 'number_of_days' => 64, 'description' => '64 Days Credit'],
            ['code' => 'Z065', 'number_of_days' => 65, 'description' => '65 Days Credit'],
            ['code' => 'Z066', 'number_of_days' => 66, 'description' => '66 Days Credit'],
            ['code' => 'Z067', 'number_of_days' => 67, 'description' => '67 Days Credit'],
            ['code' => 'Z068', 'number_of_days' => 68, 'description' => '68 Days Credit'],
            ['code' => 'Z069', 'number_of_days' => 69, 'description' => '69 Days Credit'],
            ['code' => 'Z070', 'number_of_days' => 70, 'description' => '70 Days Credit'],
            ['code' => 'Z071', 'number_of_days' => 71, 'description' => '71 Days Credit'],
            ['code' => 'Z072', 'number_of_days' => 72, 'description' => '72 Days Credit'],
            ['code' => 'Z073', 'number_of_days' => 73, 'description' => '73 Days Credit'],
            ['code' => 'Z074', 'number_of_days' => 74, 'description' => '74 Days Credit'],
            ['code' => 'Z075', 'number_of_days' => 75, 'description' => '75 Days Credit'],
            ['code' => 'Z076', 'number_of_days' => 76, 'description' => '76 Days Credit'],
            ['code' => 'Z077', 'number_of_days' => 77, 'description' => '77 Days Credit'],
            ['code' => 'Z078', 'number_of_days' => 78, 'description' => '78 Days Credit'],
            ['code' => 'Z079', 'number_of_days' => 79, 'description' => '79 Days Credit'],
            ['code' => 'Z080', 'number_of_days' => 80, 'description' => '80 Days Credit'],
            ['code' => 'Z081', 'number_of_days' => 81, 'description' => '81 Days Credit'],
            ['code' => 'Z082', 'number_of_days' => 82, 'description' => '82 Days Credit'],
            ['code' => 'Z083', 'number_of_days' => 83, 'description' => '83 Days Credit'],
            ['code' => 'Z084', 'number_of_days' => 84, 'description' => '84 Days Credit'],
            ['code' => 'Z085', 'number_of_days' => 85, 'description' => '85 Days Credit'],
            ['code' => 'Z086', 'number_of_days' => 86, 'description' => '86 Days Credit'],
            ['code' => 'Z087', 'number_of_days' => 87, 'description' => '87 Days Credit'],
            ['code' => 'Z088', 'number_of_days' => 88, 'description' => '88 Days Credit'],
            ['code' => 'Z089', 'number_of_days' => 89, 'description' => '89 Days Credit'],
            ['code' => 'Z090', 'number_of_days' => 90, 'description' => '90 Days Credit'],
            ['code' => 'Z091', 'number_of_days' => 91, 'description' => '91 Days Credit'],
            ['code' => 'Z092', 'number_of_days' => 92, 'description' => '92 Days Credit'],
            ['code' => 'Z093', 'number_of_days' => 93, 'description' => '93 Days Credit'],
            ['code' => 'Z094', 'number_of_days' => 94, 'description' => '94 Days Credit'],
            ['code' => 'Z095', 'number_of_days' => 95, 'description' => '95 Days Credit'],
            ['code' => 'Z096', 'number_of_days' => 96, 'description' => '96 Days Credit'],
            ['code' => 'Z097', 'number_of_days' => 97, 'description' => '97 Days Credit'],
            ['code' => 'Z098', 'number_of_days' => 98, 'description' => '98 Days Credit'],
            ['code' => 'Z099', 'number_of_days' => 99, 'description' => '99 Days Credit'],
            ['code' => 'Z100', 'number_of_days' => 100, 'description' => '100 Days Credit'],
            ['code' => 'Z101', 'number_of_days' => 101, 'description' => '101 Days Credit'],
            ['code' => 'Z102', 'number_of_days' => 102, 'description' => '102 Days Credit'],
            ['code' => 'Z103', 'number_of_days' => 103, 'description' => '103 Days Credit'],
            ['code' => 'Z104', 'number_of_days' => 104, 'description' => '104 Days Credit'],
            ['code' => 'Z105', 'number_of_days' => 105, 'description' => '105 Days Credit'],
            ['code' => 'Z106', 'number_of_days' => 106, 'description' => '106 Days Credit'],
            ['code' => 'Z107', 'number_of_days' => 107, 'description' => '107 Days Credit'],
            ['code' => 'Z108', 'number_of_days' => 108, 'description' => '108 Days Credit'],
            ['code' => 'Z109', 'number_of_days' => 109, 'description' => '109 Days Credit'],
            ['code' => 'Z110', 'number_of_days' => 110, 'description' => '110 Days Credit'],
            ['code' => 'Z111', 'number_of_days' => 111, 'description' => '111 Days Credit'],
            ['code' => 'Z112', 'number_of_days' => 112, 'description' => '112 Days Credit'],
            ['code' => 'Z113', 'number_of_days' => 113, 'description' => '113 Days Credit'],
            ['code' => 'Z114', 'number_of_days' => 114, 'description' => '114 Days Credit'],
            ['code' => 'Z115', 'number_of_days' => 115, 'description' => '115 Days Credit'],
            ['code' => 'Z116', 'number_of_days' => 116, 'description' => '116 Days Credit'],
            ['code' => 'Z117', 'number_of_days' => 117, 'description' => '117 Days Credit'],
            ['code' => 'Z118', 'number_of_days' => 118, 'description' => '118 Days Credit'],
            ['code' => 'Z119', 'number_of_days' => 119, 'description' => '119 Days Credit'],
            ['code' => 'Z120', 'number_of_days' => 120, 'description' => '120 Days Credit'],
            ['code' => 'Z121', 'number_of_days' => 121, 'description' => '121 Days Credit'],
            ['code' => 'Z122', 'number_of_days' => 122, 'description' => '122 Days Credit'],
            ['code' => 'Z123', 'number_of_days' => 123, 'description' => '123 Days Credit'],
            ['code' => 'Z124', 'number_of_days' => 124, 'description' => '124 Days Credit'],
            ['code' => 'Z125', 'number_of_days' => 125, 'description' => '125 Days Credit'],
            ['code' => 'Z126', 'number_of_days' => 126, 'description' => '126 Days Credit'],
            ['code' => 'Z127', 'number_of_days' => 127, 'description' => '127 Days Credit'],
            ['code' => 'Z128', 'number_of_days' => 128, 'description' => '128 Days Credit'],
            ['code' => 'Z129', 'number_of_days' => 129, 'description' => '129 Days Credit'],
            ['code' => 'Z130', 'number_of_days' => 130, 'description' => '130 Days Credit'],
            ['code' => 'Z131', 'number_of_days' => 131, 'description' => '131 Days Credit'],
            ['code' => 'Z132', 'number_of_days' => 132, 'description' => '132 Days Credit'],
            ['code' => 'Z133', 'number_of_days' => 133, 'description' => '133 Days Credit'],
            ['code' => 'Z134', 'number_of_days' => 134, 'description' => '134 Days Credit'],
            ['code' => 'Z135', 'number_of_days' => 135, 'description' => '135 Days Credit'],
            ['code' => 'Z136', 'number_of_days' => 136, 'description' => '136 Days Credit'],
            ['code' => 'Z137', 'number_of_days' => 137, 'description' => '137 Days Credit'],
            ['code' => 'Z138', 'number_of_days' => 138, 'description' => '138 Days Credit'],
            ['code' => 'Z139', 'number_of_days' => 139, 'description' => '139 Days Credit'],
            ['code' => 'Z140', 'number_of_days' => 140, 'description' => '140 Days Credit'],
            ['code' => 'Z141', 'number_of_days' => 141, 'description' => '141 Days Credit'],
            ['code' => 'Z142', 'number_of_days' => 142, 'description' => '142 Days Credit'],
            ['code' => 'Z143', 'number_of_days' => 143, 'description' => '143 Days Credit'],
            ['code' => 'Z144', 'number_of_days' => 144, 'description' => '144 Days Credit'],
            ['code' => 'Z145', 'number_of_days' => 145, 'description' => '145 Days Credit'],
            ['code' => 'Z146', 'number_of_days' => 146, 'description' => '146 Days Credit'],
            ['code' => 'Z147', 'number_of_days' => 147, 'description' => '147 Days Credit'],
            ['code' => 'Z148', 'number_of_days' => 148, 'description' => '148 Days Credit'],
            ['code' => 'Z149', 'number_of_days' => 149, 'description' => '149 Days Credit'],
            ['code' => 'Z150', 'number_of_days' => 150, 'description' => '150 Days Credit']
        ];
        foreach ($data as $row) {
            $top = MasterVendorTermsOfPayment::where('code', $row['code'])->get()->first();
            if ($top) {
                MasterVendorTermsOfPayment::where('id', $top->id)->update([
                    'number_of_days' => $row['number_of_days'],
                    'description' => $row['description']
                ]);
            } else {
                MasterVendorTermsOfPayment::insert([
                    'code' => $row['code'],
                    'number_of_days' => $row['number_of_days'],
                    'description' => $row['description']
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
