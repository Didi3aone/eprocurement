<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorBankCountryTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_bank_country', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        $data = [
            ['code' => 'AD', 'name' => 'Andorra'],
            ['code' => 'AE', 'name' => 'Utd.Arab Emir.'],
            ['code' => 'AF', 'name' => 'Afghanistan'],
            ['code' => 'AG', 'name' => 'Antigua/Barbuda'],
            ['code' => 'AI', 'name' => 'Anguilla'],
            ['code' => 'AL', 'name' => 'Albania'],
            ['code' => 'AM', 'name' => 'Armenia'],
            ['code' => 'AO', 'name' => 'Angola'],
            ['code' => 'AQ', 'name' => 'Antarctica'],
            ['code' => 'AR', 'name' => 'Argentina'],
            ['code' => 'AS', 'name' => 'Samoa, America'],
            ['code' => 'AT', 'name' => 'Austria'],
            ['code' => 'AU', 'name' => 'Australia'],
            ['code' => 'AW', 'name' => 'Aruba'],
            ['code' => 'AX', 'name' => 'Aland Islands'],
            ['code' => 'AZ', 'name' => 'Azerbaijan'],
            ['code' => 'BA', 'name' => 'Bosnia-Herz.'],
            ['code' => 'BB', 'name' => 'Barbados'],
            ['code' => 'BD', 'name' => 'Bangladesh'],
            ['code' => 'BE', 'name' => 'Belgium'],
            ['code' => 'BF', 'name' => 'Burkina Faso'],
            ['code' => 'BG', 'name' => 'Bulgaria'],
            ['code' => 'BH', 'name' => 'Bahrain'],
            ['code' => 'BI', 'name' => 'Burundi'],
            ['code' => 'BJ', 'name' => 'Benin'],
            ['code' => 'BL', 'name' => 'Blue'],
            ['code' => 'BM', 'name' => 'Bermuda'],
            ['code' => 'BN', 'name' => 'Brunei Daruss.'],
            ['code' => 'BO', 'name' => 'Bolivia'],
            ['code' => 'BQ', 'name' => 'Bonaire, Saba'],
            ['code' => 'BR', 'name' => 'Brazil'],
            ['code' => 'BS', 'name' => 'Bahamas'],
            ['code' => 'BT', 'name' => 'Bhutan'],
            ['code' => 'BV', 'name' => 'Bouvet Islands'],
            ['code' => 'BW', 'name' => 'Botswana'],
            ['code' => 'BY', 'name' => 'Belarus'],
            ['code' => 'BZ', 'name' => 'Belize'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'CC', 'name' => 'Keeling Islands'],
            ['code' => 'CD', 'name' => 'Dem. Rep. Congo'],
            ['code' => 'CF', 'name' => 'CAR'],
            ['code' => 'CG', 'name' => 'Rep.of Congo'],
            ['code' => 'CH', 'name' => 'Switzerland'],
            ['code' => 'CI', 'name' => 'Cote d\'Ivoire'],
            ['code' => 'CK', 'name' => 'Cook Islands'],
            ['code' => 'CL', 'name' => 'Chile'],
            ['code' => 'CM', 'name' => 'Cameroon'],
            ['code' => 'CN', 'name' => 'China'],
            ['code' => 'CO', 'name' => 'Colombia'],
            ['code' => 'CR', 'name' => 'Costa Rica'],
            ['code' => 'CU', 'name' => 'Cuba'],
            ['code' => 'CV', 'name' => 'Cape Verde'],
            ['code' => 'CW', 'name' => 'Curacao'],
            ['code' => 'CX', 'name' => 'Christmas Islnd'],
            ['code' => 'CY', 'name' => 'Cyprus'],
            ['code' => 'CZ', 'name' => 'Czech Republic'],
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'DJ', 'name' => 'Djibouti'],
            ['code' => 'DK', 'name' => 'Denmark'],
            ['code' => 'DM', 'name' => 'Dominica'],
            ['code' => 'DO', 'name' => 'Dominican Rep.'],
            ['code' => 'DZ', 'name' => 'Algeria'],
            ['code' => 'EC', 'name' => 'Ecuador'],
            ['code' => 'EE', 'name' => 'Estonia'],
            ['code' => 'EG', 'name' => 'Egypt'],
            ['code' => 'EH', 'name' => 'West Sahara'],
            ['code' => 'ER', 'name' => 'Eritrea'],
            ['code' => 'ES', 'name' => 'Spain'],
            ['code' => 'ET', 'name' => 'Ethiopia'],
            ['code' => 'EU', 'name' => 'European Union'],
            ['code' => 'FI', 'name' => 'Finland'],
            ['code' => 'FJ', 'name' => 'Fiji'],
            ['code' => 'FK', 'name' => 'Falkland Islnds'],
            ['code' => 'FM', 'name' => 'Micronesia'],
            ['code' => 'FO', 'name' => 'Faroe Islands'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'GA', 'name' => 'Gabon'],
            ['code' => 'GB', 'name' => 'United Kingdom'],
            ['code' => 'GD', 'name' => 'Grenada'],
            ['code' => 'GE', 'name' => 'Georgia'],
            ['code' => 'GF', 'name' => 'French Guayana'],
            ['code' => 'GG', 'name' => 'Guernsey'],
            ['code' => 'GH', 'name' => 'Ghana'],
            ['code' => 'GI', 'name' => 'Gibraltar'],
            ['code' => 'GL', 'name' => 'Greenland'],
            ['code' => 'GM', 'name' => 'Gambia'],
            ['code' => 'GN', 'name' => 'Guinea'],
            ['code' => 'GP', 'name' => 'Guadeloupe'],
            ['code' => 'GQ', 'name' => 'Equatorial Guin'],
            ['code' => 'GR', 'name' => 'Greece'],
            ['code' => 'GS', 'name' => 'S. Sandwich Ins'],
            ['code' => 'GT', 'name' => 'Guatemala'],
            ['code' => 'GU', 'name' => 'Guam'],
            ['code' => 'GW', 'name' => 'Guinea-Bissau'],
            ['code' => 'GY', 'name' => 'Guyana'],
            ['code' => 'HK', 'name' => 'Hong Kong'],
            ['code' => 'HM', 'name' => 'Heard/McDon.Isl'],
            ['code' => 'HN', 'name' => 'Honduras'],
            ['code' => 'HR', 'name' => 'Croatia'],
            ['code' => 'HT', 'name' => 'Haiti'],
            ['code' => 'HU', 'name' => 'Hungary'],
            ['code' => 'ID', 'name' => 'Indonesia'],
            ['code' => 'IE', 'name' => 'Ireland'],
            ['code' => 'IL', 'name' => 'Israel'],
            ['code' => 'IM', 'name' => 'Isle of Man'],
            ['code' => 'IN', 'name' => 'India'],
            ['code' => 'IO', 'name' => 'Brit.Ind.Oc.Ter'],
            ['code' => 'IQ', 'name' => 'Iraq'],
            ['code' => 'IR', 'name' => 'Iran'],
            ['code' => 'IS', 'name' => 'Iceland'],
            ['code' => 'IT', 'name' => 'Italy'],
            ['code' => 'JE', 'name' => 'Jersey'],
            ['code' => 'JM', 'name' => 'Jamaica'],
            ['code' => 'JO', 'name' => 'Jordan'],
            ['code' => 'JP', 'name' => 'Japan'],
            ['code' => 'KE', 'name' => 'Kenya'],
            ['code' => 'KG', 'name' => 'Kyrgyzstan'],
            ['code' => 'KH', 'name' => 'Cambodia'],
            ['code' => 'KI', 'name' => 'Kiribati'],
            ['code' => 'KM', 'name' => 'Comoros'],
            ['code' => 'KN', 'name' => 'St Kitts&Nevis'],
            ['code' => 'KP', 'name' => 'North Korea'],
            ['code' => 'KR', 'name' => 'South Korea'],
            ['code' => 'KW', 'name' => 'Kuwait'],
            ['code' => 'KY', 'name' => 'Cayman Islands'],
            ['code' => 'KZ', 'name' => 'Kazakhstan'],
            ['code' => 'LA', 'name' => 'Laos'],
            ['code' => 'LB', 'name' => 'Lebanon'],
            ['code' => 'LC', 'name' => 'St. Lucia'],
            ['code' => 'LI', 'name' => 'Liechtenstein'],
            ['code' => 'LK', 'name' => 'Sri Lanka'],
            ['code' => 'LR', 'name' => 'Liberia'],
            ['code' => 'LS', 'name' => 'Lesotho'],
            ['code' => 'LT', 'name' => 'Lithuania'],
            ['code' => 'LU', 'name' => 'Luxembourg'],
            ['code' => 'LV', 'name' => 'Latvia'],
            ['code' => 'LY', 'name' => 'Libya'],
            ['code' => 'MA', 'name' => 'Morocco'],
            ['code' => 'MC', 'name' => 'Monaco'],
            ['code' => 'MD', 'name' => 'Moldova'],
            ['code' => 'ME', 'name' => ''],
            ['code' => 'MF', 'name' => ''],
            ['code' => 'MG', 'name' => 'Madagascar'],
            ['code' => 'MH', 'name' => 'Marshall Islnds'],
            ['code' => 'MK', 'name' => 'Macedonia'],
            ['code' => 'ML', 'name' => 'Mali'],
            ['code' => 'MM', 'name' => 'Burma'],
            ['code' => 'MN', 'name' => 'Mongolia'],
            ['code' => 'MO', 'name' => 'Macau'],
            ['code' => 'MP', 'name' => 'N.Mariana Islnd'],
            ['code' => 'MQ', 'name' => 'Martinique'],
            ['code' => 'MR', 'name' => 'Mauritania'],
            ['code' => 'MS', 'name' => 'Montserrat'],
            ['code' => 'MT', 'name' => 'Malta'],
            ['code' => 'MU', 'name' => 'Mauritius'],
            ['code' => 'MV', 'name' => 'Maldives'],
            ['code' => 'MW', 'name' => 'Malawi'],
            ['code' => 'MX', 'name' => 'Mexico'],
            ['code' => 'MY', 'name' => 'Malaysia'],
            ['code' => 'MZ', 'name' => 'Mozambique'],
            ['code' => 'NA', 'name' => 'Namibia'],
            ['code' => 'NC', 'name' => 'New Caledonia'],
            ['code' => 'NE', 'name' => 'Niger'],
            ['code' => 'NF', 'name' => 'Norfolk Islands'],
            ['code' => 'NG', 'name' => 'Nigeria'],
            ['code' => 'NI', 'name' => 'Nicaragua'],
            ['code' => 'NL', 'name' => 'Netherlands'],
            ['code' => 'NO', 'name' => 'Norway'],
            ['code' => 'NP', 'name' => 'Nepal'],
            ['code' => 'NR', 'name' => 'Nauru'],
            ['code' => 'NT', 'name' => 'NATO'],
            ['code' => 'NU', 'name' => 'Niue'],
            ['code' => 'NZ', 'name' => 'New Zealand'],
            ['code' => 'OM', 'name' => 'Oman'],
            ['code' => 'OR', 'name' => 'Orange'],
            ['code' => 'PA', 'name' => 'Panama'],
            ['code' => 'PE', 'name' => 'Peru'],
            ['code' => 'PF', 'name' => 'Frenc.Polynesia'],
            ['code' => 'PG', 'name' => 'Pap. New Guinea'],
            ['code' => 'PH', 'name' => 'Philippines'],
            ['code' => 'PK', 'name' => 'Pakistan'],
            ['code' => 'PL', 'name' => 'Poland'],
            ['code' => 'PM', 'name' => 'St.Pier,Miquel.'],
            ['code' => 'PN', 'name' => 'Pitcairn Islnds'],
            ['code' => 'PR', 'name' => 'Puerto Rico'],
            ['code' => 'PS', 'name' => 'Palestine'],
            ['code' => 'PT', 'name' => 'Portugal'],
            ['code' => 'PW', 'name' => 'Palau'],
            ['code' => 'PY', 'name' => 'Paraguay'],
            ['code' => 'QA', 'name' => 'Qatar'],
            ['code' => 'RE', 'name' => 'Reunion'],
            ['code' => 'RO', 'name' => 'Romania'],
            ['code' => 'RS', 'name' => ''],
            ['code' => 'RU', 'name' => 'Russian Fed.'],
            ['code' => 'RW', 'name' => 'Rwanda'],
            ['code' => 'SA', 'name' => 'Saudi Arabia'],
            ['code' => 'SB', 'name' => 'Solomon Islands'],
            ['code' => 'SC', 'name' => 'Seychelles'],
            ['code' => 'SD', 'name' => 'Sudan'],
            ['code' => 'SE', 'name' => 'Sweden'],
            ['code' => 'SG', 'name' => 'Singapore'],
            ['code' => 'SH', 'name' => 'Saint Helena'],
            ['code' => 'SI', 'name' => 'Slovenia'],
            ['code' => 'SJ', 'name' => 'Svalbard'],
            ['code' => 'SK', 'name' => 'Slovakia'],
            ['code' => 'SL', 'name' => 'Sierra Leone'],
            ['code' => 'SM', 'name' => 'San Marino'],
            ['code' => 'SN', 'name' => 'Senegal'],
            ['code' => 'SO', 'name' => 'Somalia'],
            ['code' => 'SR', 'name' => 'Suriname'],
            ['code' => 'SS', 'name' => 'South Sudan'],
            ['code' => 'ST', 'name' => 'S.Tome,Principe'],
            ['code' => 'SV', 'name' => 'El Salvador'],
            ['code' => 'SX', 'name' => 'Sint Maarten'],
            ['code' => 'SY', 'name' => 'Syria'],
            ['code' => 'SZ', 'name' => 'Swaziland'],
            ['code' => 'TC', 'name' => 'Turksh Caicosin'],
            ['code' => 'TD', 'name' => 'Chad'],
            ['code' => 'TF', 'name' => 'French S.Territ'],
            ['code' => 'TG', 'name' => 'Togo'],
            ['code' => 'TH', 'name' => 'Thailand'],
            ['code' => 'TJ', 'name' => 'Tajikistan'],
            ['code' => 'TK', 'name' => 'Tokelau Islands'],
            ['code' => 'TL', 'name' => 'East Timor'],
            ['code' => 'TM', 'name' => 'Turkmenistan'],
            ['code' => 'TN', 'name' => 'Tunisia'],
            ['code' => 'TO', 'name' => 'Tonga'],
            ['code' => 'TR', 'name' => 'Turkey'],
            ['code' => 'TT', 'name' => 'Trinidad,Tobago'],
            ['code' => 'TV', 'name' => 'Tuvalu'],
            ['code' => 'TW', 'name' => 'Taiwan'],
            ['code' => 'TZ', 'name' => 'Tanzania'],
            ['code' => 'UA', 'name' => 'Ukraine'],
            ['code' => 'UG', 'name' => 'Uganda'],
            ['code' => 'UM', 'name' => 'Minor Outl.Isl.'],
            ['code' => 'UN', 'name' => 'United Nations'],
            ['code' => 'US', 'name' => 'USA'],
            ['code' => 'UY', 'name' => 'Uruguay'],
            ['code' => 'UZ', 'name' => 'Uzbekistan'],
            ['code' => 'VA', 'name' => 'Vatican City'],
            ['code' => 'VC', 'name' => 'St. Vincent'],
            ['code' => 'VE', 'name' => 'Venezuela'],
            ['code' => 'VG', 'name' => 'Brit.Virgin Is.'],
            ['code' => 'VI', 'name' => 'US Virgin Isl.'],
            ['code' => 'VN', 'name' => 'Vietnam'],
            ['code' => 'VU', 'name' => 'Vanuatu'],
            ['code' => 'WF', 'name' => 'Wallis,Futuna'],
            ['code' => 'WS', 'name' => 'Samoa'],
            ['code' => 'YE', 'name' => 'Yemen'],
            ['code' => 'YT', 'name' => 'Mayotte'],
            ['code' => 'ZA', 'name' => 'South Africa'],
            ['code' => 'ZM', 'name' => 'Zambia'],
            ['code' => 'ZW', 'name' => 'Zimbabwe']
        ];
        DB::table('master_vendor_bank_country')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_bank_country');
    }
}
