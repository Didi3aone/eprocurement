<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorBankKeysTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_bank_keys', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('key');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['key' => '10016  ', 'name' => 'BANK INDONESIA'],
            ['key' => '20307  ', 'name' => 'PT. BANK RAKYAT INDONESIA (Persero) Tbk.'],
            ['key' => '80017  ', 'name' => 'PT. BANK MANDIRI (Persero) Tbk.'],
            ['key' => '0090010', 'name' => 'PT. BANK NEGARA INDONESIA 1946 (Persero) Tbk.'],
            ['key' => '0110042', 'name' => 'PT. BANK DANAMON INDONESIA INDONESIA Tbk.'],
            ['key' => '0119920', 'name' => 'PT. BANK DANAMON INDONESIA INDONESIA Tbk. SYARIAH'],
            ['key' => '130475 ', 'name' => 'PT. BANK PERMATA Tbk.'],
            ['key' => '0139926', 'name' => 'PT. BANK PERMATA Tbk. SYARIAH'],
            ['key' => '140397 ', 'name' => 'PT. BANK CENTRAL ASIA Tbk.'],
            ['key' => '0160131', 'name' => 'PT. BANK MAYBANK INDONESIA'],
            ['key' => '0169925', 'name' => 'PT. BANK MAYBANK INDONESIA SYARIAH'],
            ['key' => '0190017', 'name' => 'PT. BANK PAN INDONESIA Tbk.'],
            ['key' => '220026 ', 'name' => 'PT. BANK CIMB NIAGA TBK'],
            ['key' => '0229920', 'name' => 'PT. BANK CIMB NIAGA TBK SYARIAH'],
            ['key' => '230016 ', 'name' => 'PT. BANK UOB INDONESIA'],
            ['key' => '280024 ', 'name' => 'PT. BANK OCBC NISP, Tbk.'],
            ['key' => '0289928', 'name' => 'PT. BANK OCBC NISP, Tbk. SYARIAH'],
            ['key' => '0310305', 'name' => 'CITIBANK NA'],
            ['key' => '0320308', 'name' => 'JPMORGAN CHASE BANK, NA'],
            ['key' => '0330301', 'name' => 'BANK OF AMERICA , NA'],
            ['key' => '0360300', 'name' => 'PT. BANK CHINA CONSTRUCTION BANK INDONESIA TBK.'],
            ['key' => '0370028', 'name' => 'PT. BANK ARTHA GRAHA INTERNASIONAL, TBK'],
            ['key' => '0400309', 'name' => 'THE BANGKOK BANK PCL'],
            ['key' => '0410302', 'name' => 'THE HONGKONG AND SHANGHAI BANKING CORPORATION LIMITED '],
            ['key' => '0420305', 'name' => 'MUFG BANK LTD'],
            ['key' => '0450304', 'name' => 'PT. BANK SUMITOMO MITSUI INDONESIA'],
            ['key' => '0460307', 'name' => 'PT. BANK DBS INDONESIA'],
            ['key' => '0470300', 'name' => 'PT. BANK RESONA PERDANIA'],
            ['key' => '0480303', 'name' => 'PT. BANK MIZUHO INDONESIA'],
            ['key' => '0500306', 'name' => 'STANDARD CHARTERED BANK'],
            ['key' => '0520302', 'name' => 'THE ROYAL BANK OF SCOTLAND N.V.'],
            ['key' => '0540308', 'name' => 'PT. BANK CAPITAL INDONESIA'],
            ['key' => '0570307', 'name' => 'PT. BANK BNP PARIBAS INDONESIA'],
            ['key' => '0610306', 'name' => 'PT. BANK ANZ INDONESIA'],
            ['key' => '670304 ', 'name' => 'DEUTSCHE BANK AG'],
            ['key' => '0680307', 'name' => 'PT. BANK WOORI INDONESIA'],
            ['key' => '0690300', 'name' => 'BANK OF CHINA LIMITED'],
            ['key' => '0760010', 'name' => 'PT. BANK BUMI ARTA'],
            ['key' => '0870010', 'name' => 'PT. BANK EKONOMI RAHARJA'],
            ['key' => '0880013', 'name' => 'PT. BANK ANTAR DAERAH'],
            ['key' => '0890016', 'name' => 'PT. BANK RABOBANK INTERNATIONAL INDONESIA'],
            ['key' => '0950011', 'name' => 'PT. BANK JTRUST INDONESIA'],
            ['key' => '0970017', 'name' => 'PT. BANK MAYAPADA'],
            ['key' => '1100019', 'name' => 'PT. BANK PEMBANGUNAN DAERAH JABAR DAN BANTEN'],
            ['key' => '1110012', 'name' => 'PT. BANK PEMBANGUNAN DAERAH DKI JAKARTA'],
            ['key' => '1119916', 'name' => 'PT. BANK PEMBANGUNAN DAERAH DKI JAKARTA SYARIAH'],
            ['key' => '1120015', 'name' => 'PT. BANK PEMBANGUNAN DAERAH DIY'],
            ['key' => '1129922', 'name' => 'PT. BANK PEMBANGUNAN DAERAH DIY SYARIAH'],
            ['key' => '1130348', 'name' => 'PT. BANK PEMBANGUNAN DAERAH JAWA TENGAH'],
            ['key' => '1139938', 'name' => 'PT. BANK PEMBANGUNAN DAERAH JATENG SYARIAH'],
            ['key' => '1140383', 'name' => 'PT. BANK PEMBANGUNAN JAWA TIMUR'],
            ['key' => '1150014', 'name' => 'PT. BANK PEMBANGUNAN DAERAH JAMBI'],
            ['key' => '1160017', 'name' => 'PT. BANK ACEH SYARIAH'],
            ['key' => '1169924', 'name' => 'PT. BANK ACEH'],
            ['key' => '1170010', 'name' => 'PT. BANK PEMBANGUNAN DAERAH SUMUT'],
            ['key' => '1179927', 'name' => 'PT. BANK PEMBANGUNAN DAERAH SUMUT UUS'],
            ['key' => '1180013', 'name' => 'PT. BANK PEMBANGUNAN DAERAH SUMATERA BARAT SYARIAH'],
            ['key' => '1180259', 'name' => 'PT. BPD SUMATERA BARAT'],
            ['key' => '1190016', 'name' => 'PT. BANK PEMBANGUNAN DAERAH RIAU'],
            ['key' => '1200016', 'name' => 'PT. BPD SUMSEL DAN BABEL'],
            ['key' => '1209923', 'name' => 'PT. BPD SUMSEL DAN BABEL SYARIAH'],
            ['key' => '1210051', 'name' => 'PT. BANK PEMBANGUNAN DAERAH LAMPUNG'],
            ['key' => '1220012', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALIMANTAN SELATAN'],
            ['key' => '1229929', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALIMANTAN SELATAN SYARIAH'],
            ['key' => '1230015', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALIMANTAN BARAT'],
            ['key' => '1239922', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALIMANTAN BARAT SYARIAH'],
            ['key' => '1240018', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALIMANTAN TIMUR'],
            ['key' => '1249925', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALTIM SYARIAH'],
            ['key' => '1250011', 'name' => 'PT. BANK PEMBANGUNAN DAERAH KALTENG'],
            ['key' => '1260027', 'name' => 'PT. BANK SULSELBAR'],
            ['key' => '1270017', 'name' => 'PT. BANK PEMBANGUNAN SULAWESI UTARA'],
            ['key' => '1280010', 'name' => 'PT. BANK PEMBANGUNAN DAERAH NTB SYARIAH'],
            ['key' => '1290013', 'name' => 'PT. BANK PEMBANGUNAN DAERAH BALI'],
            ['key' => '1300013', 'name' => 'BANK PEMBANGUNAN DAERAH NUSA TENGGARA TIMUR'],
            ['key' => '1310016', 'name' => 'PT. BANK PEMBANGUNAN DAERAH MALUKU'],
            ['key' => '1320019', 'name' => 'PT. BANK PEMBANGUNAN DAERAH PAPUA'],
            ['key' => '1330012', 'name' => 'PT. BPD BENGKULU'],
            ['key' => '1340015', 'name' => 'PT. BANK PEMBANGUNAN DAERAH SULAWESI TENGAH'],
            ['key' => '1350018', 'name' => 'PT. BANK PEMBANGUNAN DAERAH SULAWESI TENGGARA'],
            ['key' => '1450015', 'name' => 'PT. BANK NUSANTARA PARAHYANGAN'],
            ['key' => '1460047', 'name' => 'PT. BANK OF INDIA INDONESIA, TBK'],
            ['key' => '1470011', 'name' => 'PT. BANK MUAMALAT INDONESIA'],
            ['key' => '1510010', 'name' => 'PT. BANK MESTIKA DHARMA'],
            ['key' => '1520013', 'name' => 'PT. BANK SHINHAN INDONESIA'],
            ['key' => '1530016', 'name' => 'PT. BANK SINARMAS'],
            ['key' => '1539923', 'name' => 'PT. BANK SINARMAS SYARIAH'],
            ['key' => '1570018', 'name' => 'PT. BANK MASPION INDONESIA'],
            ['key' => '1610017', 'name' => 'PT. BANK GANESHA'],
            ['key' => '1640058', 'name' => 'PT. BANK ICBC INDONESIA'],
            ['key' => '1670015', 'name' => 'PT. BANK QNB KESAWAN'],
            ['key' => '2000150', 'name' => 'PT. BANK TABUNGAN NEGARA (Persero)'],
            ['key' => '2009928', 'name' => 'PT. BANK TABUNGAN NEGARA (Persero)-SYARIAH'],
            ['key' => '2120001', 'name' => 'PT. BANK HS 1906'],
            ['key' => '2130101', 'name' => 'PT. BANK BTPN'],
            ['key' => '4050072', 'name' => 'PT. BANK VICTORIA SYARIAH'],
            ['key' => '4220051', 'name' => 'PT. BANK SYARIAH BRI'],
            ['key' => '4250018', 'name' => 'PT. BANK JABAR BANTEN SYARIAH'],
            ['key' => '4260121', 'name' => 'PT. BANK MEGA Tbk.'],
            ['key' => '4270027', 'name' => 'PT. BANK BNI SYARIAH'],
            ['key' => '4410010', 'name' => 'PT. BANK UMUM KOPERASI INDONESIA (BUKOPIN)'],
            ['key' => '4510017', 'name' => 'PT. BANK SYARIAH MANDIRI'],
            ['key' => '4590011', 'name' => 'PT. BANK BISNIS INTERNATIONAL'],
            ['key' => '4660019', 'name' => 'PT. BANK OKE INDONESIA'],
            ['key' => '4720014', 'name' => 'PT. BANK JASA JAKARTA'],
            ['key' => '4840017', 'name' => 'PT. BANK KEB HANA INDONESIA'],
            ['key' => '4850010', 'name' => 'PT. BANK MNC INTERNASIONAL, TBK'],
            ['key' => '4900012', 'name' => 'PT. BANK YUDHA BHAKTI'],
            ['key' => '4910015', 'name' => 'PT. BANK MITRANIAGA'],
            ['key' => '4940014', 'name' => 'PT. BANK RAKYAT INDONESIA AGRONIAGA, TBK'],
            ['key' => '4980016', 'name' => 'PT. BANK SBI INDONESIA'],
            ['key' => '5010011', 'name' => 'PT. BANK ROYAL INDONESIA'],
            ['key' => '5030017', 'name' => 'PT. BANK NATIONALNOBU'],
            ['key' => '5060016', 'name' => 'PT. BANK MEGA SYARIAH'],
            ['key' => '5130014', 'name' => 'PT. BANK INA PERDANA'],
            ['key' => '5170016', 'name' => 'PT. BANK PANIN SYARIAH'],
            ['key' => '5200012', 'name' => 'PT. PRIMA MASTER BANK'],
            ['key' => '5210031', 'name' => 'PT. BANK SYARIAH BUKOPIN'],
            ['key' => '5230011', 'name' => 'PT. BANK SAHABAT SAMPOERNA'],
            ['key' => '5260010', 'name' => 'PT. BANK DINAR INDONESIA'],
            ['key' => '5310012', 'name' => 'PT. BANK AMAR INDONESIA'],
            ['key' => '5350014', 'name' => 'PT. BANK KESEJAHTERAAN EKONOMI'],
            ['key' => '5360020', 'name' => 'PT. BANK BCA SYARIAH'],
            ['key' => '5420012', 'name' => 'PT. BANK ARTOS INDONESIA'],
            ['key' => '5470046', 'name' => 'PT. BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH'],
            ['key' => '5480010', 'name' => 'PT. BANK MULTIARTA SENTOSA'],
            ['key' => '5530012', 'name' => 'PT. BANK MAYORA INDONESIA'],
            ['key' => '5550018', 'name' => 'PT. BANK INDEX SELINDO'],
            ['key' => '5580017', 'name' => 'PT. BANK PUNDI INDONESIA, TBK'],
            ['key' => '5590010', 'name' => 'PT. CENTRATAMA NASIONAL BANK'],
            ['key' => '5620016', 'name' => 'PT. BANK FAMA INTERNATIONAL'],
            ['key' => '5640012', 'name' => 'PT. BANK SINAR HARAPAN BALI'],
            ['key' => '5660018', 'name' => 'PT. BANK VICTORIA INTERNATIONAL'],
            ['key' => '5670011', 'name' => 'PT. BANK HARDA INTERNASIONAL'],
            ['key' => '9450305', 'name' => 'PT. BANK AGRIS '],
            ['key' => '9470302', 'name' => 'PT. BANK MAYBANK SYARIAH INDONESIA'],
            ['key' => '9490307', 'name' => 'PT. BANK CTBC INDONESIA'],
            ['key' => '9500307', 'name' => 'PT. BANK COMMONWEALTH'],
            ['key' => '9999999', 'name' => 'Bank Key Dummy']
        ];
        DB::table('master_vendor_bank_keys')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_bank_keys');
    }
}
