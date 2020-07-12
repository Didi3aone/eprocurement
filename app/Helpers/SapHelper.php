<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use SoapClient;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use App\Models\Vendor\Billing;
use App\Models\Vendor\BillingDetail;
use App\Models\PurchaseOrdersDetail;
use App\Models\PurchaseRequestDetail;
use App\Models\Materials;

/**
 * Sap Helper
 * integrasi sistem dengan sap
 * @package SAP HELPER
 * @author Didi Triawan
 * @link 
 * @license MIT
 * @version 2.2
 */
class SapHelper {

    public const ActiveEnv = 1;
    public const Username  = 'IT_02';
    public const Password  = 'ademsari';

    /**
     * get url soaps
     * @param string $soapModul
     * @return void
     */
    public static function getSoapXml($soapModul)
    {
        $soapUrl    = DB::connection('pgsql3')->table('soap_urls')
                    ->where('soap_module', $soapModul)
                    ->first();
        return $soapUrl;
    }

    /**
     * get history PO
     * @author didi
     * @param bigint $materialCode
     * @return \Illuminate\Http\Response
     */
    public static function getHistoryPo($materialCode)
    {
        $wsdl = public_path()."/xml/zbn_eproc_histpo.xml";
        
        $username = \sapHelp::Username;
        $password = \sapHelp::Password;

        $client = new \SoapClient($wsdl, array(
            'login' => \sapHelp::Username,
            'password' => \sapHelp::Password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        $params = [];
        $params[0]['MATNR'] = '00000000000'.$materialCode;
        $params[0]['RFQ_DETAIL']['item'] = [];
        $params[0]['RFQ_HEADER']['item']=[];

        $result = $client->__soapCall('ZFM_WS_HISTPO', $params, NULL, $header);
        
        $data = [];
        $data['header'] = $result->RFQ_HEADER;
        $data['detail'] = $result->RFQ_DETAIL;

        return $data;
    }

    /**
     * send pr to sap
     * @author didi
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    public static function sendToSAP( $data = [] )
    {
        $soapFile = \sapHelp::getSoapXml('PURCHASE_REQUEST');
        if( $soapFile->is_active_env == \App\Models\BaseModel::Development ) {
            $wsdl = public_path()."/xml/zbn_eproc_pr.xml";
        } else {
            $wsdl = public_path() ."/xml/". $soapFile->xml_file;
        }
        
        $username = \sapHelp::Username;
        $password = \sapHelp::Password;

        $client = new \SoapClient($wsdl, array(
            'login' => \sapHelp::Username,
            'password' => \sapHelp::Password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        //init variable
        $params = [];
        $params[0]['REQUISITION_ITEMS'] = [];
        $params[0]['REQUISITION_ITEM_TEXT'] = [];
        $params[0]['REQUISITION_ACCOUNT_ASSIGNMENT'] = [];
        $params[0]['REQUISITION_SERVICES'] = [];
        $params[0]['REQUISITION_SRV_ACCASS_VALUES'] = [];
        $params[0]['REQUISITION_LIMITS'] = [];
        $params[0]['REQUISITION_SERVICES_TEXT'] = [];
        $params[0]['RETURN'] = [];
        $REQUISITION_ITEMS_item = [];
        $REQUISITION_ACCOUNT_ASSIGNMENT_item = [];
        $REQUISITION_ITEM_TEXT_item = [];
        $REQUISITION_ITEM_SERVICE_item = [];
        $REQUISISTION_ITEMS_SRV_ACCASS_VALUES_item = [];
        $REQUISITION_SERVICES_TEXT_item = [];
        $REQUISITION_LIMITS_item = [];
        
        $is_array = (count($data)>1)?true:false;
        for ($i=0; $i < count($data); $i++) {
            if($data[$i]['CATEGORY'] == PurchaseRequest::STANDART
            OR $data[$i]['CATEGORY'] == PurchaseRequest::MaterialText) {
                $category = PurchaseRequest::STANDART;
            }
            
            //check category
            if( $data[$i]['CATEGORY'] == PurchaseRequest::STANDART 
                OR $data[$i]['CATEGORY'] == PurchaseRequest::MaterialText) {
                $REQUISITION_ITEMS_item = [
                    'PREQ_NO'           => '',
                    'PREQ_ITEM'         => $data[$i]['PREQ_ITEM'],
                    'DOC_TYPE'          => $data[$i]['DOC_TYPE'], // 'Z101',
                    'PUR_GROUP'         => $data[$i]['PUR_GROUP'], // 'S03',
                    'CREATED_BY'        => '',
                    'PREQ_NAME'         => $data[$i]['PREQ_NAME'], // 'PROD PL 3',
                    'PREQ_DATE'         => date('Y-m-d'),//date('Y-m-d'),
                    'SHORT_TEXT'        => strtoupper($data[$i]['SHORT_TEXT']), // 'MATERIAL DAN INSTALASI PSG',
                    'MATERIAL'          => isset($data[$i]['MATERIAL']) && $data[$i]['MATERIAL'] != '' ? '00000000000'.$data[$i]['MATERIAL'] : '',
                    'PUR_MAT'           => '',
                    'PLANT'             => $data[$i]['PLANT'], // '1201',
                    'STORE_LOC'         => $data[$i]['STORE_LOC'], // 'B300',
                    'TRACKINGNO'        => $data[$i]['TRACKINGNO'],
                    'MAT_GRP'           => $data[$i]['MAT_GRP'],//'T12075',, 
                    'SUPPL_PLNT'        => '',
                    'QUANTITY'          => $data[$i]['QUANTITY'], // '1.000',
                    'UNIT'              => $data[$i]['UNIT'], // 'LOT',
                    'DEL_DATCAT'        => '',
                    'DELIV_DATE'        => $data[$i]['DELIV_DATE'],//'2020-06-23',
                    'REL_DATE'          => $data[$i]['REL_DATE'],//'2020-03-06',//
                    'GR_PR_TIME'        => 0,
                    'C_AMT_BAPI'        => '0.0000',
                    'PRICE_UNIT'        => 0,
                    'ACCTASSCAT'        => $data[$i]['ACCTASSCAT'] == 'H' ? '' : $data[$i]['ACCTASSCAT'], // 'A',
                    'DISTRIB'           => '',
                    'PART_INV'          => '',
                    'GR_IND'            => 'X',
                    'GR_NON_VAL'        => '',
                    'IR_IND'            => 'X',
                    'DES_VENDOR'        => '',
                    'FIXED_VEND'        => '',
                    'PURCH_ORG'         => '0000',
                    'AGREEMENT'         => '',
                    'AGMT_ITEM'         => '00000',
                    'INFO_REC'          => '',
                    'QUOTA_ARR'         => '',
                    'QUOTARRITM'        => '000',
                    'MRP_CONTR'         => '',
                    'BOMEXPL_NO'        => '',
                    'LAST_RESUB'        => '',
                    'RESUBMIS'          => 0,
                    'NO_RESUB'          => 0,
                    'VAL_TYPE'          => '',
                    'SPEC_STOCK'        => '',
                    'PO_UNIT'           => '',
                    'REV_LEV'           => '',
                    'PCKG_NO'           => '0000000000',
                    'KANBAN_IND'        => '',
                    'PO_PRICE'          => '',
                    'INT_OBJ_NO'        => '000000000000000000',
                    'PROMOTION'         => '',
                    'BATCH'             => '',
                    'VEND_MAT'          => '',
                    'ORDERED'           => '0.000',
                    'CURRENCY'          => '',
                    'MANUF_PROF'        => '',
                    'MANU_MAT'          => '',
                    'MFR_NO'            => '',
                    'MFR_NO_EXT'        => '',
                    'DEL_DATCAT_EXT'    => '',
                    'CURRENCY_ISO'      => '',
                    'ITEM_CAT_EXT'      => '',
                    'PREQ_UNIT_ISO'     => '',
                    'PO_UNIT_ISO'       => '',
                    'GENERAL_RELEASE'   => '',
                    'MATERIAL_EXTERNAL' => '',
                    'MATERIAL_GUID'     => '',
                    'MATERIAL_VERSION'  => '',
                    'PUR_MAT_EXTERNAL'  => '',
                    'PUR_MAT_GUID'      => '',
                    'PUR_MAT_VERSION'   => '',
                    'REQ_BLOCKED'       => '',
                    'REASON_BLOCKING'   => '',
                    'PROCURING_PLANT'   => '',
                    'CMMT_ITEM'         => '',
                    'FUNDS_CTR'         => '',
                    'FUND'              => '',
                    'RES_DOC'           => '',
                    'RES_ITEM'          => '000',
                    'FUNC_AREA'         => '',
                    'GRANT_NBR'         => '',
                    'FUND_LONG'         => '',
                    'BUDGET_PERIOD'     => '',
                    'MATERIAL_LONG'     => '',
                    'PUR_MAT_LONG'      => '',
                    'ITEM_CAT'          => $category
                ];

                $REQUISITION_ITEM_TEXT_item = [
                    'PREQ_NO'       => '',
                    'PREQ_ITEM'     => $data[$i]['PREQ_ITEM'],
                    'TEXT_ID'       => $data[$i]['TEXT_ID'], // 'B01',
                    'TEXT_FORM'     => $data[$i]['TEXT_FORM'], // 'EN',
                    'TEXT_LINE'     => $data[$i]['TEXT_LINE'] // 'UNTUK RUANG TRAVO TRIMAS'
                ];

                $REQUISITION_ACCOUNT_ASSIGNMENT_item =  [
                    'PREQ_NO'       => '',
                    'PREQ_ITEM'     => $data[$i]['PREQ_ITEM'],
                    'SERIAL_NO'     => '00',
                    'DELETE_IND'    => '',
                    'CREATED_ON'    => '',
                    'CREATED_BY'    => '',
                    'PREQ_QTY'      => $data[$i]['QUANTITY'], // '1.000',
                    'DISTR_PERC'    => '0.0',
                    'G_L_ACCT'      => $data[$i]['G_L_ACCT'] ?? '', // '2132013001',
                    'BUS_AREA'      => '',
                    'COST_CTR'      => $data[$i]['COST_CTR'] ?? '',
                    'PROJ_NO'       => '',
                    'SD_DOC'        => '',
                    'SDOC_ITEM'     => '000000',
                    'SCHED_LINE'    => '0000',
                    'ASSET_NO'      => $data[$i]['ASSET_NO'] ?? '', // '390000000179',
                    'SUB_NUMBER'    => '',
                    'ORDER_NO'      => '',
                    'GR_RCPT'       => '',
                    'UNLOAD_PT'     => '',
                    'CO_AREA'       => 'EGCA',//$data[$i]['CO_AREA'], // 'EGCA',
                    'TO_COSTCTR'    => '',
                    'TO_ORDER'      => '',
                    'TO_PROJECT'    => '',
                    'COST_OBJ'      => '',
                    'PROF_SEGM'     => '0000000000',
                    'PROFIT_CTR'    => ($data[$i]['ACCTASSCAT'] == 'A') ? '' : '0000'.$data[$i]['PROFIT_CTR'], // '0000120001',
                    'WBS_ELEM'      => '',
                    'NETWORK'       => '',
                    'ROUTING_NO'    => '000000000',
                    'RL_EST_KEY'    => '',
                    'PART_ACCT'     => '',
                    'CMMT_ITEM'     => '',
                    'REC_IND'       => '',
                    'FUNDS_CTR'     => '',
                    'FUND'          => '',
                    'FUNC_AREA'     => '',
                    'REF_DATE'      => '',
                    'CHANGE_ID'     => '',
                    'CURRENCY'      => '',
                    'PREQ_UNIT'     => '',
                    'WBS_ELEM_E'    => '',
                    'PROJ_EXT'      => '',
                    'ACTIVITY'      => '',
                    'FUNC_AREA_LONG'    => '',
                    'GRANT_NBR'         => '',
                    'CMMT_ITEM_LONG'    => '',
                    'RES_DOC'           => '',
                    'FUND_LONG'         => '',
                    'BUDGET_PERIOD'     => '',
                    'FMFGUS_KEY'        => '',
                    'COUNTER'           => '00000000',
                    'RES_ITEM'          => '000'
                ];

                $REQUISITION_ITEM_SERVICE_item = [
                    "PCKG_NO"           =>'',
                    "LINE_NO"           => '',
                    "EXT_LINE"          => '',
                    "OUTL_LEVEL"        => '',
                    "OUTL_NO"           => '',
                    "OUTL_IND"          => '',
                    "SUBPCKG_NO"        => '',
                    "SERVICE"           => '',
                    "SERV_TYPE"         => '',
                    "EDITION"           => '',
                    "SSC_ITEM"          => '', 
                    "EXT_SERV"          => '', 
                    "QUANTITY"          => '', 
                    "BASE_UOM"          => '', 
                    "UOM_ISO"           => '', 
                    "OVF_TOL"           => '', 
                    "OVF_UNLIM"         => '', 
                    "PRICE_UNIT"        => '', 
                    "GR_PRICE"          => '', 
                    "FROM_LINE"         => '', 
                    "TO_LINE"           => '', 
                    "SHORT_TEXT"        => '', 
                    "DISTRIB"           => '', 
                    "PERS_NO"           => '', 
                    "WAGETYPE"          => '', 
                    "PLN_PCKG"          => '', 
                    "PLN_LINE"          => '', 
                    "CON_PCKG"          => '', 
                    "CON_LINE"          => '', 
                    "TMP_PCKG"          => '', 
                    "TMP_LINE"          => '', 
                    "SSC_LIM"           => '', 
                    "LIMIT_LINE"        => '', 
                    "TARGET_VAL"        => '', 
                    "BASLINE_NO"        => '', 
                    "BASIC_LINE"        => '', 
                    "ALTERNAT"          => '', 
                    "BIDDER"            => '', 
                    "SUPP_LINE"         => '', 
                    "OPEN_QTY"          => '', 
                    "INFORM"            => '', 
                    "BLANKET"           => '', 
                    "EVENTUAL"          => '', 
                    "TAX_CODE"          => '', 
                    "TAXJURCODE"        => '', 
                    "PRICE_CHG"         => '', 
                    "MATL_GROUP"        => '', 
                    "DATE"              => '', 
                    "BEGINTIME"         => '', 
                    "ENDTIME"           => '', 
                    "EXTPERS_NO"        => '', 
                    "FORMULA"           => '', 
                    "FORM_VAL1"         => '', 
                    "FORM_VAL2"         => '', 
                    "FORM_VAL3"         => '', 
                    "FORM_VAL4"         => '', 
                    "FORM_VAL5"         => '', 
                    "USERF1_NUM"        => '', 
                    "USERF2_NUM"        => '', 
                    "USERF1_TXT"        => '', 
                    "USERF2_TXT"        => '', 
                    "HI_LINE_NO"        => '', 
                    "EXTREFKEY"         => '', 
                    "DELETE_IND"        => '', 
                    "PER_SDATE"         => '', 
                    "PER_EDATE"         => '', 
                    "EXTERNAL_ITEM_ID"  => '', 
                    "SERVICE_ITEM_KEY"  => '', 
                    "NET_VALUE"         => '', 
                ];

                $REQUISISTION_ITEMS_SRV_ACCASS_VALUES_item = [
                    "PCKG_NO"       => '',
                    "LINE_NO"       => '',
                    "SERNO_LINE"    =>'',
                    "PERCENTAGE"    => '',
                    "SERIAL_NO"     => '',
                    "QUANTITY"      => '',
                    "NET_VALUE"     =>''
                ];

                $REQUISITION_SERVICES_TEXT_item = [
                    "PCKG_NO"       => '',
                    "LINE_NO"       => '',
                    "TEXT_ID"       => '',
                    "FORMAT_COL"    => '',
                    "TEXT_LINE"     => '',
                ];

                $REQUISITION_LIMITS_item = [
                    "PCKG_NO"       => '',
                    "LIMIT"         => '',
                    "NO_LIMIT"      => '',
                    "EXP_VALUE"     => '',
                    "SSC_EXIST"     => '',
                    "CON_EXIST"     => '',
                    "TMP_EXIST"     => '',
                    "PRICE_CHG"     => '',
                    "FREE_LIMIT"    => '',
                    "NO_FRLIMIT"    => '',
                    "SERV_TYPE"     => '',
                    "EDITION"       => '',
                    "SSC_LIMIT"     => '',
                    "SSC_NOLIM"     => '',
                    "SSC_PRSCHG"    => '',
                    "SSC_PERC"      => '',
                    "TMP_NUMBER"    => '',
                    "TMP_LIMIT"     => '',
                    "TMP_NOLIM"     => '',
                    "TMP_PRSCHG"    => '',
                    "TMP_PERC"      => '',
                    "CONT_PERC"     => '',
                ];

            } elseif($data[$i]['CATEGORY'] == PurchaseRequest::SERVICE ) {

                if( $data[$i]['LINE_NO'] == '0000000001' ) {
                    $package_no = $data[$i]['PACKAGE_NO'];
                } else {
                    $package_no = $data[$i]['SUBPACKAGE_NO'];
                }

                $REQUISITION_ITEMS_item = [
                    'PREQ_NO'           => '',
                    'PREQ_ITEM'         => $data[$i]['PREQ_ITEM'],//('000'.(10+($i*10))),
                    'DOC_TYPE'          => $data[$i]['DOC_TYPE'],//'Z104', // 'Z101',
                    'PUR_GROUP'         => $data[$i]['PUR_GROUP'], // 'S03',
                    'CREATED_BY'        => '',
                    'PREQ_NAME'         => $data[$i]['PREQ_NAME'], // 'PROD PL 3',
                    'PREQ_DATE'         => date('Y-m-d'),//date('Y-m-d'),
                    'SHORT_TEXT'        => \strtoupper($data[$i]['SHORT_TEXT']), // 'MATERIAL DAN INSTALASI PSG',
                    'MATERIAL'          => '',
                    'PUR_MAT'           => '',
                    'PLANT'             => $data[$i]['PLANT'], // '1201',
                    'STORE_LOC'         => $data[$i]['STORE_LOC'], // 'B300',
                    'TRACKINGNO'        => $data[$i]['TRACKINGNO'],//$data[$i]['TRACKINGNO']
                    'MAT_GRP'           => $data[$i]['MAT_GRP'],//'T12075',, 
                    'SUPPL_PLNT'        => '',
                    'QUANTITY'          => $data[$i]['QUANTITY'], // '1.000',
                    'UNIT'              => $data[$i]['UNIT'], // 'LOT',
                    'DEL_DATCAT'        => '',
                    'DELIV_DATE'        =>  $data[$i]['DELIV_DATE'],//'2020-06-23',
                    'REL_DATE'          =>  $data[$i]['REL_DATE'],//'2020-03-06',//
                    'GR_PR_TIME'        => '0',
                    'C_AMT_BAPI'        => '0.0000',
                    'ITEM_CAT'          => '9',
                    'PRICE_UNIT'        => '0',
                    'ACCTASSCAT'        => $data[$i]['ACCTASSCAT'] == 'H' ? '' : $data[$i]['ACCTASSCAT'], // 'A',
                    'DISTRIB'           => '',
                    'PART_INV'          => '',
                    'GR_IND'            => 'X',
                    'GR_NON_VAL'        => '',
                    'IR_IND'            =>  'X',
                    'DES_VENDOR'        => '',
                    'FIXED_VEND'        => '',
                    'PURCH_ORG'         => '0000',
                    'AGREEMENT'         => '',
                    'AGMT_ITEM'         => '00000',
                    'INFO_REC'          => '',
                    'QUOTA_ARR'         => '',
                    'QUOTARRITM'        => '000',
                    'MRP_CONTR'         => '',
                    'BOMEXPL_NO'        => '',
                    'LAST_RESUB'        => '',
                    'RESUBMIS'          => 0,
                    'NO_RESUB'          => 0,
                    'VAL_TYPE'          => '',
                    'SPEC_STOCK'        => '',
                    'PO_UNIT'           => '',
                    'REV_LEV'           => '',
                    'PCKG_NO'           => $package_no,
                    'KANBAN_IND'        => '',
                    'PO_PRICE'          => '',
                    'INT_OBJ_NO'        => '000000000000000000',
                    'PROMOTION'         => '',
                    'BATCH'             => '',
                    'VEND_MAT'          => '',
                    'ORDERED'           => '0.000',
                    'CURRENCY'          => '',
                    'MANUF_PROF'        => '',
                    'MANU_MAT'          => '',
                    'MFR_NO'            => '',
                    'MFR_NO_EXT'        => '',
                    'DEL_DATCAT_EXT'    => '',
                    'CURRENCY_ISO'      => '',
                    'ITEM_CAT_EXT'      => '',
                    'PREQ_UNIT_ISO'     => '',
                    'PO_UNIT_ISO'       => '',
                    'GENERAL_RELEASE'   => '',
                    'MATERIAL_EXTERNAL' => '',
                    'MATERIAL_GUID'     => '',
                    'MATERIAL_VERSION'  => '',
                    'PUR_MAT_EXTERNAL'  => '',
                    'PUR_MAT_GUID'      => '',
                    'PUR_MAT_VERSION'   => '',
                    'REQ_BLOCKED'       => '',
                    'REASON_BLOCKING'   => '',
                    'PROCURING_PLANT'   => '',
                    'CMMT_ITEM'         => '',
                    'FUNDS_CTR'         => '',
                    'FUND'              => '',
                    'RES_DOC'           => '',
                    'RES_ITEM'          => '000',
                    'FUNC_AREA'         => 'Z181',
                    'GRANT_NBR'         => '',
                    'FUND_LONG'         => 'Z181',
                    'BUDGET_PERIOD'     => '',
                    'MATERIAL_LONG'     => '',
                    'PUR_MAT_LONG'      => '',
                ];

                $REQUISITION_ACCOUNT_ASSIGNMENT_item = [
                    'PREQ_NO'       => '',
                    'PREQ_ITEM'     => $data[$i]['PREQ_ITEM'],//('000'.(10+($i*10))),
                    'SERIAL_NO'     => '01',
                    'DELETE_IND'    => '',
                    'CREATED_ON'    => '',
                    'CREATED_BY'    => '',
                    'PREQ_QTY'      => $data[$i]['QUANTITY'], // '1.000',
                    'DISTR_PERC'    => '0.0',
                    'G_L_ACCT'      => $data[$i]['G_L_ACCT'], // '   ',
                    'BUS_AREA'      => '',
                    'COST_CTR'      => $data[$i]['COST_CTR'],
                    'PROJ_NO'       => '',
                    'SD_DOC'        => '',
                    'SDOC_ITEM'     => '000000',
                    'SCHED_LINE'    => '0000',
                    'ASSET_NO'      => '', // '390000000179',
                    'SUB_NUMBER'    => '',
                    'ORDER_NO'      => '',
                    'GR_RCPT'       => '',
                    'UNLOAD_PT'     => '',
                    'CO_AREA'       => 'EGCA',//$data[$i]['CO_AREA'], // 'EGCA',
                    'TO_COSTCTR'    => '',
                    'TO_ORDER'      => '',
                    'TO_PROJECT'    => '',
                    'COST_OBJ'      => '',
                    'PROF_SEGM'     => '0000000000',
                    'PROFIT_CTR'    => '0000'.$data[$i]['PROFIT_CTR'], // '0000120001',
                    'WBS_ELEM'      => '',
                    'NETWORK'       => '',
                    'ROUTING_NO'    => '000000000',
                    'RL_EST_KEY'    => '',
                    'PART_ACCT'     => '',
                    'CMMT_ITEM'     => '',
                    'REC_IND'       => '',
                    'FUNDS_CTR'     => '',
                    'FUND'          => '',
                    'FUNC_AREA'     => '',
                    'REF_DATE'      => '',
                    'CHANGE_ID'     => '',
                    'CURRENCY'      => '',
                    'PREQ_UNIT'     => '',
                    'WBS_ELEM_E'    => '',
                    'PROJ_EXT'      => '',
                    'ACTIVITY'      => '',
                    'FUNC_AREA_LONG' => '',
                    'GRANT_NBR'      => '',
                    'CMMT_ITEM_LONG' => '',
                    'RES_DOC'        => '',
                    'FUND_LONG'      => '',
                    'BUDGET_PERIOD'  => '',
                    'FMFGUS_KEY'     => '',
                    'COUNTER'        => '00000000',
                    'RES_ITEM'       => '000'
                ];

                $REQUISITION_ITEM_TEXT_item = [
                    'PREQ_NO'       => '',
                    'PREQ_ITEM'     => $data[$i]['PREQ_ITEM'],//('000'.(10+($i*10))),
                    'TEXT_ID'       =>  'B01',
                    'TEXT_FORM'     => 'EN',
                    'TEXT_LINE'     => $data[$i]['TEXT_LINE'] // 'UNTUK RUANG TRAVO TRIMAS'
                ];

                $REQUISITION_ITEM_SERVICE_item = [
                    "PCKG_NO"            => $package_no,
                    "LINE_NO"            => $data[$i]['LINE_NO'],
                    "EXT_LINE"           => '0000000000',
                    "OUTL_LEVEL"         => '0',
                    "OUTL_NO"            => '',
                    "OUTL_IND"           => '',
                    "SUBPCKG_NO"         => $data[$i]['SUBPACKAGE_NO'],
                    "SERVICE"            => '',
                    "SERV_TYPE"          => '',
                    "EDITION"            => '0000',
                    "SSC_ITEM"           => '', 
                    "EXT_SERV"           => '', 
                    "QUANTITY"           => $data[$i]['QUANTITY'], 
                    "BASE_UOM"           => $data[$i]['UNIT'], 
                    "UOM_ISO"            => '', 
                    "OVF_TOL"            => '', 
                    "OVF_UNLIM"          => '', 
                    "PRICE_UNIT"         => '0', 
                    "GR_PRICE"           => '0.0000', 
                    "FROM_LINE"          => '', 
                    "TO_LINE"            => '', 
                    "SHORT_TEXT"         => $data[$i]['TEXT_LINE'], 
                    "DISTRIB"            => '', 
                    "PERS_NO"            => '00000000', 
                    "WAGETYPE"           => '', 
                    "PLN_PCKG"           => '', 
                    "PLN_LINE"           => '', 
                    "CON_PCKG"           => '', 
                    "CON_LINE"           => '', 
                    "TMP_PCKG"           => '', 
                    "TMP_LINE"           => '', 
                    "SSC_LIM"            => '', 
                    "LIMIT_LINE"         => '', 
                    "TARGET_VAL"         => '', 
                    "BASLINE_NO"         => '', 
                    "BASIC_LINE"         => '', 
                    "ALTERNAT"           => '', 
                    "BIDDER"             => '', 
                    "SUPP_LINE"          => '', 
                    "OPEN_QTY"           => '', 
                    "INFORM"             => '', 
                    "BLANKET"            => '', 
                    "EVENTUAL"           => '', 
                    "TAX_CODE"           => '', 
                    "TAXJURCODE"         => '', 
                    "PRICE_CHG"          => '', 
                    "MATL_GROUP"         => '', 
                    "DATE"               => '', 
                    "BEGINTIME"          => '', 
                    "ENDTIME"            => '', 
                    "EXTPERS_NO"         => '', 
                    "FORMULA"            => '', 
                    "FORM_VAL1"          => '', 
                    "FORM_VAL2"          => '', 
                    "FORM_VAL3"          => '', 
                    "FORM_VAL4"          => '', 
                    "FORM_VAL5"          => '', 
                    "USERF1_NUM"         => '', 
                    "USERF2_NUM"         => '', 
                    "USERF1_TXT"         => '', 
                    "USERF2_TXT"         => '', 
                    "HI_LINE_NO"         => '', 
                    "EXTREFKEY"          => '', 
                    "DELETE_IND"         => '', 
                    "PER_SDATE"          => '', 
                    "PER_EDATE"          => '', 
                    "EXTERNAL_ITEM_ID"   => '', 
                    "SERVICE_ITEM_KEY"   => '', 
                    "NET_VALUE"          => '', 
                ];

                $REQUISISTION_ITEMS_SRV_ACCASS_VALUES_item = [
                    "PCKG_NO"       => $package_no,
                    "LINE_NO"       => $data[$i]['LINE_NO'],
                    "SERNO_LINE"    =>'01',
                    "PERCENTAGE"    => '100',
                    "SERIAL_NO"     => '01',
                    "QUANTITY"      => $data[$i]['QUANTITY'],
                    "NET_VALUE"     =>''
                ];

                $REQUISITION_SERVICES_TEXT_item = [
                    "PCKG_NO"       => $package_no,
                    "LINE_NO"       => '',
                    "TEXT_ID"       => '',
                    "FORMAT_COL"    => '',
                    "TEXT_LINE"     => '',
                ];

                $REQUISITION_LIMITS_item = [
                    "PCKG_NO"       => $package_no,
                    "LIMIT"         => '',
                    "NO_LIMIT"      => '',
                    "EXP_VALUE"     => '',
                    "SSC_EXIST"     => '',
                    "CON_EXIST"     => '',
                    "TMP_EXIST"     => '',
                    "PRICE_CHG"     => '',
                    "FREE_LIMIT"    => '',
                    "NO_FRLIMIT"    => '',
                    "SERV_TYPE"     => '',
                    "EDITION"       => '',
                    "SSC_LIMIT"     => '',
                    "SSC_NOLIM"     => '',
                    "SSC_PRSCHG"    => '',
                    "SSC_PERC"      => '',
                    "TMP_NUMBER"    => '',
                    "TMP_LIMIT"     => '',
                    "TMP_NOLIM"     => '',
                    "TMP_PRSCHG"    => '',
                    "TMP_PERC"      => '',
                    "CONT_PERC"     => '',
                ];
            }

            if ($is_array) {
                $params[0]['REQUISITION_ITEMS']['item'][$i] = $REQUISITION_ITEMS_item;
                $params[0]['REQUISITION_ITEM_TEXT']['item'][$i] = $REQUISITION_ITEM_TEXT_item;
                $params[0]['REQUISITION_ACCOUNT_ASSIGNMENT']['item'][$i] = $REQUISITION_ACCOUNT_ASSIGNMENT_item;
                $params[0]['REQUISITION_SERVICES']['item'][$i] = $REQUISITION_ITEM_SERVICE_item;
                $params[0]['REQUISITION_SRV_ACCASS_VALUES']['item'][$i] = $REQUISISTION_ITEMS_SRV_ACCASS_VALUES_item;
                $params[0]['REQUISITION_SERVICES_TEXT']['item'][$i] = $REQUISITION_SERVICES_TEXT_item;
                $params[0]['REQUISITION_LIMITS']['item'][$i] = $REQUISITION_LIMITS_item;
            } else {
                $params[0]['REQUISITION_ITEMS']['item'] = $REQUISITION_ITEMS_item;
                $params[0]['REQUISITION_ITEM_TEXT']['item'] = $REQUISITION_ITEM_TEXT_item;
                $params[0]['REQUISITION_ACCOUNT_ASSIGNMENT']['item'] = $REQUISITION_ACCOUNT_ASSIGNMENT_item;
                $params[0]['REQUISITION_SERVICES']['item'] = $REQUISITION_ITEM_SERVICE_item;
                $params[0]['REQUISITION_SRV_ACCASS_VALUES']['item'] = $REQUISISTION_ITEMS_SRV_ACCASS_VALUES_item;
                $params[0]['REQUISITION_SERVICES_TEXT']['item'][$i] = $REQUISITION_SERVICES_TEXT_item;
                $params[0]['REQUISITION_LIMITS']['item'][$i] = $REQUISITION_LIMITS_item;
            }
        }

        try {
            $result = $client->__soapCall("ZFM_WS_PR", $params, NULL, $header);
            // dd($result);
            return $result;
        } catch (\Exception $e){
            throw new \Exception("Soup request failed! Response: ".$client->__getLastResponse());
        }
    }

    /**
     * Send po  to sap
     * @version V1
     * @author didi
     * @param string $poNumber
     * @return void
     */
    public static function sendPoToSap($quotation, $quotationDetail, $quotationDeliveryDate)
    {
        $wsdl = public_path() . "/xml/zbn_eproc_po.xml";
        
        $username = "IT_02";
        $password = "ademsari";

        $client = new \SoapClient($wsdl, array(
            'login' => $username,
            'password' => $password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        $params = [];
        $params[0]['POHEADER'] = [];
        $params[0]['POHEADERX'] = [];
        $params[0]['POTEXTHEADER'] = [];
        $params[0]['POITEM'] = [];
        $params[0]['POITEMX'] = [];
        $params[0]['POSCHEDULE'] = [];
        $params[0]['POSCHEDULEX'] = [];
        $params[0]['RETURN'] = [];
        $POITEM = [];
        $POITEMX = [];
        $POACCOUNT = [];
        $POSERVICES = [];
        $POSRVACCESSVALUES = [];

        $POHEADER = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => $quotation->doc_type,
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '000'.$quotation->vendor_id ?? '0003000046',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => $quotation->payment_term ?? '',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => $quotation->currency ?? 'IDR',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',//'2020-06-12',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];
        $POHEADERX = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => 'X',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => 'X',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => 'X',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => 'X',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];

        $POTEXTHEADER = [
            "PO_NUMBER" => '', 
            "PO_ITEM" =>  '00010',
            "TEXT_ID" =>  'EKKO',
            "TEXT_FORM" =>  'EN',
            "TEXT_LINE" =>  $quotation->notes
        ];

        $params[0]['POHEADER'] = $POHEADER;
        $params[0]['POHEADERX'] = $POHEADERX;

        $params[0]['POTEXTHEADER'] = $POTEXTHEADER;

        $count_ = count($quotationDetail);
        $is_array = ((int)$count_) > 1 ? true : false;
        for ($i=0; $i < $count_; $i++) { 
            $indexes = $i+1;
            $poItem = ('000'.(10+($i*10)));
            $schedLine = ('000'.($i+1));

            // if( $quotationDetail[$i]->item_category == \App\Models\Vendor\QuotationDetail::STANDART ) {
            $POITEM = [
                'PO_ITEM' => $quotationDetail[$i]->PO_ITEM,//LINE
                'DELETE_IND' => '',
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => '',
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => $quotationDetail[$i]->price ?? '1000000',
                'PRICE_UNIT' => '',
                'GR_PR_TIME' => '',
                'TAX_CODE' => $quotationDetail[$i]->tax_code == 1 ? 'V1' : 'V0',
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => (string) $quotationDetail[$i]->PR_NO,
                'PREQ_ITEM' => $quotationDetail[$i]->PREQ_ITEM,
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'GRANT_NBR' => '',
                'CMMT_ITEM_LONG' => '',
                'FUNC_AREA_LONG' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'FUND_LONG' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];

            $POITEMX = [
                'PO_ITEM' => $quotationDetail[$i]->PO_ITEM,
                'PO_ITEMX' => 'X',
                'DELETE_IND' => '',
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => '',
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => 'X',
                'PRICE_UNIT' => '',
                'GR_PR_TIME' => '',
                'TAX_CODE' => 'X',
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => 'X',
                'PREQ_ITEM' => 'X',
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'GRANT_NBR' => '',
                'FUNC_AREA_LONG' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];

            $POSCHEDULE = [
                "PO_ITEM" => $quotationDetail[$i]->PO_ITEM, //line
                "SCHED_LINE" => '0001',//$quotationDeliveryDate[$i]->SCHED_LINE, // 0001 ++
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => $quotationDeliveryDate[$i]->DELIVERY_DATE,//delivery date
                "QUANTITY" =>  (string) $quotationDeliveryDate[$i]->QUANTITY,// qty
                "DELIV_TIME" => "", 
                "STAT_DATE" => "",
                "PREQ_NO" =>  (string) $quotationDetail[$i]->PR_NO, // kedua no pr di insert
                "PREQ_ITEM" => $quotationDeliveryDate[$i]->PREQ_ITEM, // line 
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];

            $POSCHEDULEX = [
                "PO_ITEM" => $quotationDetail[$i]->PO_ITEM,
                "SCHED_LINE" => '0001',//$quotationDeliveryDate[$i]->SCHED_LINE,
                "PO_ITEMX" => "X",
                "SCHED_LINEX" => "X",
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => "X",
                "QUANTITY" => "X",
                "DELIV_TIME" => "",
                "STAT_DATE" => "",
                "PREQ_NO" => "X",
                "PREQ_ITEM" => "X",
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];
                // $POACCOUNT = [
                //     'PO_ITEM' => $quotationDetail[$i]->PO_ITEM,//00010
                //     'SERIAL_NO' => '01',//01
                //     'DELETE_IND' => '',
                //     'CREAT_DATE' => '',
                //     'QUANTITY' => '',
                //     'DISTR_PERC' => '',
                //     'NET_VALUE' => '',
                //     'GL_ACCOUNT' => '',// DARI PR 
                //     'BUS_AREA' => '',
                //     'COSTCENTER' => '', //DARI PR
                //     'SD_DOC' => '',
                //     'ITM_NUMBER' => '' ,
                //     'SCHED_LINE' =>'' ,
                //     'ASSET_NO' => '',
                //     'SUB_NUMBER' => '',
                //     'ORDERID' => '',
                //     'GR_RCPT' => '',
                //     'UNLOAD_PT' => '',
                //     'CO_AREA' => '',
                //     'COSTOBJECT' => '',
                //     'PROFIT_CTR' => '',
                //     'WBS_ELEMENT' => '',
                //     'NETWORK' => '',
                //     'RL_EST_KEY' => '',
                //     'PART_ACCT' => '',
                //     'CMMT_ITEM' => '',
                //     'REC_IND' => '',
                //     'FUNDS_CTR' => '',
                //     'FUND' => '',
                //     'FUNC_AREA' => '',
                //     'REF_DATE' => '',
                //     'TAX_CODE' => '',
                //     'TAXJURCODE' => '',
                //     'NOND_ITAX' => '',
                //     'ACTTYPE' => '',
                //     'CO_BUSPROC' => '',
                //     'RES_DOC' => '',
                //     'RES_ITEM' => '',
                //     'ACTIVITY' => '',
                //     'GRANT_NBR' => '',
                //     'CMMT_ITEM_LONG' => '',
                //     'FUNC_AREA_LONG'=> '',
                //     'BUDGET_PERIOD' =>'' ,
                //     'FINAL_IND' => '',                    
                //     'FINAL_REASON' => ''
                // ];

                // $POACCOUNTX = [
                //     'PO_ITEM' => $quotationDetail[$i]->PO_ITEM,//00010
                //     'PO_ITEMX'  => 'X',
                //     'SERIAL_NO' => '',//01
                //     'SERIAL_NOX'    => 'X',
                //     'DELETE_IND' => '',
                //     'CREAT_DATE' => '',
                //     'QUANTITY' => '',
                //     'DISTR_PERC' => '',
                //     'NET_VALUE' => '',
                //     'GL_ACCOUNT' => '',// DARI PR 
                //     'BUS_AREA' => '',
                //     'COSTCENTER' => '', //DARI PR
                //     'SD_DOC' => '',
                //     'ITM_NUMBER' => '' ,
                //     'SCHED_LINE' =>'' ,
                //     'ASSET_NO' => '',
                //     'SUB_NUMBER' => '',
                //     'ORDERID' => '',
                //     'GR_RCPT' => '',
                //     'UNLOAD_PT' => '',
                //     'CO_AREA' => '',
                //     'COSTOBJECT' => '',
                //     'PROFIT_CTR' => '',
                //     'WBS_ELEMENT' => '',
                //     'NETWORK' => '',
                //     'RL_EST_KEY' => '',
                //     'PART_ACCT' => '',
                //     'CMMT_ITEM' => '',
                //     'REC_IND' => '',
                //     'FUNDS_CTR' => '',
                //     'FUND' => '',
                //     'FUNC_AREA' => '',
                //     'REF_DATE' => '',
                //     'TAX_CODE' => '',
                //     'TAXJURCODE' => '',
                //     'NOND_ITAX' => '',
                //     'ACTTYPE' => '',
                //     'CO_BUSPROC' => '',
                //     'RES_DOC' => '',
                //     'RES_ITEM' => '',
                //     'ACTIVITY' => '',
                //     'GRANT_NBR' => '',
                //     'CMMT_ITEM_LONG' => '',
                //     'FUNC_AREA_LONG'=> '',
                //     'BUDGET_PERIOD' =>'' ,
                //     'FINAL_IND' => '',                    
                //     'FINAL_REASON' => ''
                // ];
                // $POSERVICES = [
                //     "PCKG_NO" => '',//0 = 9X 1; CHILD = 2 DST 
                //     "LINE_NO" =>  '',//0 = 9X 1; CHILD = 2 DST
                //     "EXT_LINE" =>  "",//CHILD = 0 = 9X 1
                //     "OUTL_LEVEL" => "",
                //     "OUTL_NO" => "",    
                //     "OUTL_IND" => "",
                //     "SUBPCKG_NO" => '',// 0 = 9X 2;
                //     "SERVICE" => "", 
                //     "SERV_TYPE" =>"",    
                //     "EDITION" =>"",
                //     "SSC_ITEM" => "",
                //     "EXT_SERV" => "",
                //     "QUANTITY" => '',//DARI PR 
                //     "BASE_UOM" => "",     
                //     "UOM_ISO" => "",    
                //     "OVF_TOL" => "",
                //     "OVF_UNLIM" => "",    
                //     "PRICE_UNIT" => "",
                //     "GR_PRICE" =>  '',//NET PRICE 
                //     "FROM_LINE" => "",    
                //     "TO_LINE" => "",    
                //     "SHORT_TEXT" => '',// DARI PR
                //     "DISTRIB" =>  "",    
                //     "PERS_NO" =>  "",
                //     "WAGETYPE" => "",    
                //     "PLN_PCKG" => "",
                //     "PLN_LINE" => "",
                //     "CON_PCKG" => "",
                //     "CON_LINE" => "",
                //     "TMP_PCKG" => "",
                //     "TMP_LINE" => "",
                //     "SSC_LIM" => "",    
                //     "LIMIT_LINE" => "",
                //     "TARGET_VAL" => "",
                //     "BASLINE_NO" => "",
                //     "BASIC_LINE" => "",    
                //     "ALTERNAT" => "",    
                //     "BIDDER" => "",    
                //     "SUPP_LINE" => "",    
                //     "OPEN_QTY" => "",    
                //     "INFORM" => "",    
                //     "BLANKET" => "",    
                //     "EVENTUAL" => "",    
                //     "TAX_CODE" => "",    
                //     "TAXJURCODE" => "",  
                //     "PRICE_CHG" => "",    
                //     "MATL_GROUP" => "",    
                //     "DATE" => "", 
                //     "BEGINTIME" => "",                        
                //     "ENDTIME" => "",                        
                //     "EXTPERS_NO" => "", 
                //     "FORMULA" => "",   
                //     "FORM_VAL1" => "",
                //     "FORM_VAL2" => "",
                //     "FORM_VAL3" => "",
                //     "FORM_VAL4" => "",
                //     "FORM_VAL5" => "",
                //     "USERF1_NUM" => "",
                //     "USERF2_NUM" => "",
                //     "USERF1_TXT" => "",    
                //     "USERF2_TXT" => "",
                //     "HI_LINE_NO" => "",
                //     "EXTREFKEY" => "",
                //     "DELETE_IND" => "",    
                //     "PER_SDATE" => "",
                //     "PER_EDATE" => "",
                //     "EXTERNAL_ITEM_ID" => "",
                //     "SERVICE_ITEM_KEY" => "",
                //     "NET_VALUE" =>"",
                // ];

                // $POSRVACCESSVALUES = [
                //     "PCKG_NO" => '',// 0 = 9X  2 DST 
                //     "LINE_NO" => '',//  0 = 9X  2 DST 
                //     "SERNO_LINE" => "",//01
                //     "PERCENTAGE" => "",// 100
                //     "SERIAL_NO" => "",//01
                //     "QUANTITY" => "",
                //     "NET_VALUE" => ""///>
                // ];
            // } 

            if ($is_array) {
                $params[0]['POITEM']['item'][$i] = $POITEM;
                $params[0]['POITEMX']['item'][$i] = $POITEMX;
                $params[0]['POSCHEDULE']['item'][$i] = $POSCHEDULE;
                $params[0]['POSCHEDULEX']['item'][$i] = $POSCHEDULEX;
                // $params[0]['POACCOUNT']['item'][$i] = $POACCOUNT;
                // $params[0]['POACCOUNTX']['item'][$i] = $POACCOUNTX;
                // $params[0]['POSERVICES']['item'][$i] = $POSERVICES;
                // $params[0]['POSRVACCESSVALUES']['item'][$i] = $POSRVACCESSVALUES;
            } else {
                $params[0]['POITEM']['item'] = $POITEM;
                $params[0]['POITEMX']['item'] = $POITEMX;
                $params[0]['POSCHEDULE']['item'] = $POSCHEDULE;
                $params[0]['POSCHEDULEX']['item'] = $POSCHEDULEX;
            }
        
        }
         
        $RETURN = [
            "TYPE" => "",
            "ID" => "",
            "NUMBER" => "",
            "MESSAGE" => "",
            "LOG_NO" => "",
            "LOG_MSG_NO" => "",
            "MESSAGE_V1" => "",
            "MESSAGE_V2" => "",
            "MESSAGE_V3" => "",
            "MESSAGE_V4" => "",
            "PARAMETER" => "",
            "ROW" => "",
            "FIELD" => "",
            "SYSTEM" => "0"
        ];

        $params[0]['RETURN'] = $RETURN;
        $result = $client->__soapCall('ZFM_WS_PO', $params, NULL, $header);
        if( $result->EXPPURCHASEORDER) {
            \App\Models\employeeApps\SapLogSoap::create([
                'log_type' => 'PURCHASE ORDER',
                'log_type_id' => $quotation->id,
                'log_params_employee' => \json_encode($params),
                'log_response_sap' => $result->EXPPURCHASEORDER,
                'status' => 'SUCCESS',
            ]); 
            return $result->EXPPURCHASEORDER;
        } else {
            \App\Models\employeeApps\SapLogSoap::create([
                'log_type' => 'PURCHASE ORDER',
                'log_type_id' => $quotation->id,
                'log_params_employee' => \json_encode($params),
                'log_response_sap' => \json_encode($result),
                'status' => 'FAILED',
            ]); 

            return $result->EXPPURCHASEORDER;
        }
    }

    /**
     * Send po change to sap
     * @version V1
     * @author didi
     * @param string $poNumber
     * @return void
     */
    public static function sendPOchangeToSap($poNumber)
    {
        $wsdl = public_path() . "/xml/zbn_eproc_pochange.xml";
        
        $username = "IT_02";
        $password = "ademsari";

        $client = new \SoapClient($wsdl, array(
            'login' => $username,
            'password' => $password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        $params = [];
        $params[0]['POHEADER'] = [];
        $params[0]['POHEADERX'] = [];
        $params[0]['POITEM'] = [];
        $params[0]['POITEMX'] = [];
        // $params[0]['POSCHEDULE'] = [];
        // $params[0]['POSCHEDULEX'] = [];
        $params[0]['PURCHASEORDER'] = [];
        $params[0]['RETURN'] = [];
        $POITEM = [];
        $POITEMX = [];

        //get data
        $poHeader = PurchaseOrder::where('PO_NUMBER',$poNumber)->first();
        $poDetail = PurchaseOrdersDetail::where('purchase_order_id',$poHeader->id)->get();

        $POHEADER = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => $poHeader->doc_type,
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => $poHeader->payment_term ?? '',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => $poHeader->currency ?? 'IDR',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',//'2020-06-12',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];
        $POHEADERX = [
            'PO_NUMBER' => '',
            'COMP_CODE' => '',
            'DOC_TYPE' => 'X',
            'DELETE_IND' => '',
            'STATUS' => '',
            'CREAT_DATE' => '',
            'CREATED_BY' => '',
            'ITEM_INTVL' => '',
            'VENDOR' => '',
            'LANGU' => '',
            'LANGU_ISO' => '',
            'PMNTTRMS' => 'X',
            'DSCNT1_TO' => '',
            'DSCNT2_TO' => '',
            'DSCNT3_TO' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'PURCH_ORG' => '',
            'PUR_GROUP' => '',
            'CURRENCY' => 'X',
            'CURRENCY_ISO' => '',
            'EXCH_RATE' => '',
            'EX_RATE_FX' => '',
            'DOC_DATE' => '',
            'VPER_START' => '',
            'VPER_END' => '',
            'WARRANTY' => '',
            'QUOTATION' => '',
            'QUOT_DATE' => '',
            'REF_1' => '',
            'SALES_PERS' => '',
            'TELEPHONE' => '',
            'SUPPL_VEND' => '',
            'CUSTOMER' => '',
            'AGREEMENT' => '',
            'GR_MESSAGE' => '',
            'SUPPL_PLNT' => '',
            'INCOTERMS1' => '',
            'INCOTERMS2' => '',
            'COLLECT_NO' => '',
            'DIFF_INV' => '',
            'OUR_REF' => '',
            'LOGSYSTEM' => '',
            'SUBITEMINT' => '',
            'PO_REL_IND' => '',
            'REL_STATUS' => '',
            'VAT_CNTRY' => '',
            'VAT_CNTRY_ISO' => '',
            'REASON_CANCEL' => '',
            'REASON_CODE' => '',
            'RETENTION_TYPE' => '',
            'RETENTION_PERCENTAGE' => '',
            'DOWNPAY_TYPE' => '',
            'DOWNPAY_AMOUNT' => '',
            'DOWNPAY_PERCENT' => '',
            'DOWNPAY_DUEDATE' => '',
            'MEMORY' => '',
            'MEMORYTYPE' => '',
            'SHIPTYPE' => '',
            'HANDOVERLOC' => '',
            'SHIPCOND' => '',
            'INCOTERMSV' => '',
            'INCOTERMS2L' => '',
            'INCOTERMS3L' => '',
            'EXT_SYS' => '',
            'EXT_REF' => ''
        ];

        $params[0]['POHEADER'] = $POHEADER;
        $params[0]['POHEADERX'] = $POHEADERX;

        $count_ = count($poDetail);
        $is_array = ((int)$count_) > 1 ? true : false;
        for ($i=0; $i < $count_; $i++) { 
            $indexes = $i+1;
            $poItem = ('000'.(10+($i*10)));
            $schedLine = ('000'.($i+1));

            $itemDelete = "";
            if( $poDetail[$i]->is_active == 0 ) {
                $itemDelete = 'X';
            }

            $deliveryComplete = "";
            if( $poDetail[$i]->delivery_complete == 1 ) {
                $deliveryComplete = 'X';
            }
            $POITEM = [
                'PO_ITEM' => $poDetail[$i]->PO_ITEM,//LINE
                'DELETE_IND' => $itemDelete,
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => $poDetail[$i]->qty,
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => $poDetail[$i]->price,
                'PRICE_UNIT' => '',
                'GR_PR_TIME' => '',
                'TAX_CODE' => $poDetail[$i]->tax_code,
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => '',
                'PREQ_ITEM' => '',
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'GRANT_NBR' => '',
                'CMMT_ITEM_LONG' => '',
                'FUNC_AREA_LONG' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'FUND_LONG' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];

            $POITEMX = [
                'PO_ITEM' => $poDetail[$i]->PO_ITEM,
                'PO_ITEMX' => 'X',
                'DELETE_IND' => $itemDelete,
                'SHORT_TEXT' => '',
                'MATERIAL' => '',
                'MATERIAL_EXTERNAL' => '',
                'MATERIAL_GUID' => '',
                'MATERIAL_VERSION' => '',
                'EMATERIAL' => '',
                'EMATERIAL_EXTERNAL' => '',
                'EMATERIAL_GUID' => '',
                'EMATERIAL_VERSION' => '',
                'PLANT' => '',
                'STGE_LOC' => '',
                'TRACKINGNO' => '',
                'MATL_GROUP' => '',
                'INFO_REC' => '',
                'VEND_MAT' => '',
                'QUANTITY' => 'X',
                'PO_UNIT' => '',
                'PO_UNIT_ISO' => '',
                'ORDERPR_UN' => '',
                'ORDERPR_UN_ISO' => '',
                'CONV_NUM1' => '',
                'CONV_DEN1' => '',
                'NET_PRICE' => '',
                'PRICE_UNIT' => '',
                'GR_PR_TIME' => '',
                'TAX_CODE' => '',
                'BON_GRP1' => '',
                'QUAL_INSP' => '',
                'INFO_UPD' => '',
                'PRNT_PRICE' => '',
                'EST_PRICE' => '',
                'REMINDER1' => '',
                'REMINDER2' => '',
                'REMINDER3' => '',
                'OVER_DLV_TOL' => '',
                'UNLIMITED_DLV' => '',
                'UNDER_DLV_TOL' => '',
                'VAL_TYPE' => '',
                'NO_MORE_GR' => '',
                'FINAL_INV' => '',
                'ITEM_CAT' => '',
                'ACCTASSCAT' => '',
                'DISTRIB' => '',
                'PART_INV' => '',
                'GR_IND' => '',
                'GR_NON_VAL' => '',
                'IR_IND' => '',
                'FREE_ITEM' => '',
                'GR_BASEDIV' => '',
                'ACKN_REQD' => '',
                'ACKNOWL_NO' => '',
                'AGREEMENT' => '',
                'AGMT_ITEM' => '',
                'SHIPPING' => '',
                'CUSTOMER' => '',
                'COND_GROUP' => '',
                'NO_DISCT' => '',
                'PLAN_DEL' => '',
                'NET_WEIGHT' => '',
                'WEIGHTUNIT' => '',
                'WEIGHTUNIT_ISO' => '',
                'TAXJURCODE' => '',
                'CTRL_KEY' => '',
                'CONF_CTRL' => '',
                'REV_LEV' => '',
                'FUND' => '',
                'FUNDS_CTR' => '',
                'CMMT_ITEM' => '',
                'PRICEDATE' => '',
                'PRICE_DATE' => '',
                'GROSS_WT' => '',
                'VOLUME' => '',
                'VOLUMEUNIT' => '',
                'VOLUMEUNIT_ISO' => '',
                'INCOTERMS1' => '',
                'INCOTERMS2' => '',
                'PRE_VENDOR' => '',
                'VEND_PART' => '',
                'HL_ITEM' => '',
                'GR_TO_DATE' => '',
                'SUPP_VENDOR' => '',
                'SC_VENDOR' => '',
                'KANBAN_IND' => '',
                'ERS' => '',
                'R_PROMO' => '',
                'POINTS' => '',
                'POINT_UNIT' => '',
                'POINT_UNIT_ISO' => '',
                'SEASON' => '',
                'SEASON_YR' => '',
                'BON_GRP2' => '',
                'BON_GRP3' => '',
                'SETT_ITEM' => '',
                'MINREMLIFE' => '',
                'RFQ_NO' => '',
                'RFQ_ITEM' => '',
                'PREQ_NO' => '',
                'PREQ_ITEM' => '',
                'REF_DOC' => '',
                'REF_ITEM' => '',
                'SI_CAT' => '',
                'RET_ITEM' => '',
                'AT_RELEV' => '',
                'ORDER_REASON' => '',
                'BRAS_NBM' => '',
                'MATL_USAGE' => '',
                'MAT_ORIGIN' => '',
                'IN_HOUSE' => '',
                'INDUS3' => '',
                'INF_INDEX' => '',
                'UNTIL_DATE' => '',
                'DELIV_COMPL' => '',
                'PART_DELIV' => '',
                'SHIP_BLOCKED' => '',
                'PREQ_NAME' => '',
                'PERIOD_IND_EXPIRATION_DATE' => '',
                'INT_OBJ_NO' => '',
                'PCKG_NO' => '',
                'BATCH' => '',
                'VENDRBATCH' => '',
                'CALCTYPE' => '',
                'NO_ROUNDING' => '',
                'PO_PRICE' => '',
                'SUPPL_STLOC' => '',
                'SRV_BASED_IV' => '',
                'FUNDS_RES' => '',
                'RES_ITEM' => '',
                'GRANT_NBR' => '',
                'FUNC_AREA_LONG' => '',
                'ORIG_ACCEPT' => '',
                'ALLOC_TBL' => '',
                'ALLOC_TBL_ITEM' => '',
                'SRC_STOCK_TYPE' => '',
                'REASON_REJ' => '',
                'CRM_SALES_ORDER_NO' => '',
                'CRM_SALES_ORDER_ITEM_NO' => '',
                'CRM_REF_SALES_ORDER_NO' => '',
                'CRM_REF_SO_ITEM_NO' => '',
                'PRIO_URGENCY' => '',
                'PRIO_REQUIREMENT' => '',
                'REASON_CODE' => '',
                'LONG_ITEM_NUMBER' => '',
                'EXTERNAL_SORT_NUMBER' => '',
                'EXTERNAL_HIERARCHY_TYPE' => '',
                'RETENTION_PERCENTAGE' => '',
                'DOWNPAY_TYPE' => '',
                'DOWNPAY_AMOUNT' => '',
                'DOWNPAY_PERCENT' => '',
                'DOWNPAY_DUEDATE' => '',
                'EXT_RFX_NUMBER' => '',
                'EXT_RFX_ITEM' => '',
                'EXT_RFX_SYSTEM' => '',
                'SRM_CONTRACT_ID' => '',
                'SRM_CONTRACT_ITM' => '',
                'BUDGET_PERIOD' => '',
                'BLOCK_REASON_ID' => '',
                'BLOCK_REASON_TEXT' => '',
                'SPE_CRM_FKREL' => '',
                'DATE_QTY_FIXED' => '',
                'GI_BASED_GR' => '',
                'SHIPTYPE' => '',
                'HANDOVERLOC' => '',
                'TC_AUT_DET' => '',
                'MANUAL_TC_REASON' => '',
                'FISCAL_INCENTIVE' => '',
                'FISCAL_INCENTIVE_ID' => '',
                'TAX_SUBJECT_ST' => '',
                'REQ_SEGMENT' => '',
                'STK_SEGMENT' => '',
                'SF_TXJCD' => '',
                'INCOTERMS2L' => '',
                'INCOTERMS3L' => '',
                'MATERIAL_LONG' => '',
                'EMATERIAL_LONG' => '',
                'SERVICEPERFORMER' => '',
                'PRODUCTTYPE' => '',
                'STARTDATE' => '',
                'ENDDATE' => '',
                'REQ_SEG_LONG' => '',
                'STK_SEG_LONG' => '',
                'EXPECTED_VALUE' => '',
                'LIMIT_AMOUNT' => '',
                'EXT_REF' => '',
            ];
        
            $POSCHEDULE = [
                "PO_ITEM" => $poDetail[$i]->PO_ITEM, //line
                "SCHED_LINE" => $poDetail[$i]->SCHED_LINE, // 0001 ++
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => $poDetail[$i]->delivery_date,//delivery date
                "QUANTITY" =>  (string) $poDetail[$i]->qty,// qty
                "DELIV_TIME" => "", 
                "STAT_DATE" => "",
                "PREQ_NO" =>  (string) $poDetail[$i]->PR_NO, // kedua no pr di insert
                "PREQ_ITEM" => $poDetail[$i]->preq_item, // line 
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];

            $POSCHEDULEX = [
                "PO_ITEM" => $poDetail[$i]->PO_ITEM,
                "SCHED_LINE" => $poDetail[$i]->SHED_LINE,
                "PO_ITEMX" => "X",
                "SCHED_LINEX" => "X",
                "DEL_DATCAT_EXT" => "",
                "DELIVERY_DATE" => "X",
                "QUANTITY" => "X",
                "DELIV_TIME" => "",
                "STAT_DATE" => "",
                "PREQ_NO" => "X",
                "PREQ_ITEM" => "X",
                "PO_DATE" => "",
                "ROUTESCHED" => "",
                "MS_DATE" => "",
                "MS_TIME" => "",
                "LOAD_DATE" => "",
                "LOAD_TIME" => "",
                "TP_DATE" => "",
                "TP_TIME" => "",
                "GI_DATE" => "",
                "GI_TIME" => "",
                "DELETE_IND" => "",
                "REQ_CLOSED" => "",
                "GR_END_DATE" => "",
                "GR_END_TIME" => "",
                "COM_QTY" => "",
                "COM_DATE" => "",
                "GEO_ROUTE" => "",
                "HANDOVERDATE" => "",
                "HANDOVERTIME" => "",
            ];

            if ($is_array) {
                $params[0]['POITEM']['item'][$i] = $POITEM;
                $params[0]['POITEMX']['item'][$i] = $POITEMX;
               // $params[0]['POSCHEDULE']['item'][$i] = $POSCHEDULE;
                //$params[0]['POSCHEDULEX']['item'][$i] = $POSCHEDULEX;
            } else {
                $params[0]['POITEM']['item'] = $POITEM;
                $params[0]['POITEMX']['item'] = $POITEMX;
                //$params[0]['POSCHEDULE']['item'] = $POSCHEDULE;
                //$params[0]['POSCHEDULEX']['item'] = $POSCHEDULEX;
            }
        
        }
        $params[0]['PURCHASEORDER'] = $poHeader->PO_NUMBER;
        
        $RETURN = [
            "TYPE" => "",
            "ID" => "",
            "NUMBER" => "",
            "MESSAGE" => "",
            "LOG_NO" => "",
            "LOG_MSG_NO" => "",
            "MESSAGE_V1" => "",
            "MESSAGE_V2" => "",
            "MESSAGE_V3" => "",
            "MESSAGE_V4" => "",
            "PARAMETER" => "",
            "ROW" => "",
            "FIELD" => "",
            "SYSTEM" => "0"
        ];
        $params[0]['RETURN'] = $RETURN;
      
        $result = $client->__soapCall('ZFM_WS_POCHANGE', $params, NULL, $header);
        return $result;
    }

    /**
     * Send Billing to sap
     * @version V1
     * @author didi
     * @param array $data
     * @return void
     */
    public static function sendBillingToSap($data = [])
    {
        $purchaseOrder = PurchaseOrder::where('PO_NUMBER', $data['po_no'])->first();
        $docType = $purchaseOrder->doc_type;

        $wsdl = public_path() . "/xml/zbn_wms_do.xml";
        
        $username = "IT_02";
        $password = "ademsari";

        $client = new \SoapClient($wsdl, array(
            'login' => $username,
            'password' => $password,
            'trace' => true
        ));

        $auth = ['Username' => $username, 'Password' => $password];
        $header = new \SoapHeader("http://0003427388-one-off.sap.com/YGYHI4A8Y_", "Authentication", $auth, false);
        $client->__setSoapHeaders($header);

        $params = [];
        $billing = Billing::find($data->id);
        // dd($billing);
        $billingDetail = BillingDetail::where('billing_id', $data->id)->get();
        $params[0]['HEADERDATA'] = [];
        $params[0]['ITEMDATA'] = [];
        $params[0]['RETURN'] = [];

        $compCode = "";
        if( $billingDetail[0]->plant_code == '1101' ) {
            $compCode = '1100';
        } else if( $billingDetail[0]->plant_code == '1201' ) {
            $compCode = '1200';
        } else if( $billingDetail[0]->plant_code == '2101' ) {
            $compCode = '2100';
        }

        $TAXDATA = [];
        $WITHTAXDATA = [];

        $HEADER = [ 
            'INVOICE_IND' => 'X',
            'DOC_TYPE' => 'RE',
            'DOC_DATE' => $billing->tgl_invoice,
            'PSTNG_DATE' => date('Y-06-d'),
            'REF_DOC_NO' => $billing->invoice_no,
            'COMP_CODE' => $compCode,
            'DIFF_INV' => '',
            'CURRENCY' => $billing->currency,
            'CURRENCY_ISO' => '',
            'EXCH_RATE' =>'',// $billing->exchange_rate,
            'EXCH_RATE_V' => '',
            'GROSS_AMOUNT' => $billing->nominal_inv_after_ppn,
            'CALC_TAX_IND' => $billing->ppn == 'V1' ? 'X' : '',
            'PMNTTRMS' => $billing->payment_term_claim,//'Z003',
            'BLINE_DATE' => $billing->base_line_date,//'2020-05-01',
            'DSCT_DAYS1' => '',
            'DSCT_DAYS2' => '',
            'NETTERMS' => '',
            'DSCT_PCT1' => '',
            'DSCT_PCT2' => '',
            'IV_CATEGORY' => '',
            'HEADER_TXT' => '',
            'PMNT_BLOCK' => '',
            'DEL_COSTS' => '', 
            'DEL_COSTS_TAXC' => '',
            'DEL_COSTS_TAXJ' => '',
            'PERSON_EXT' => '',
            'PYMT_METH' => 'T',
            'PMTMTHSUPL' => '',
            'INV_DOC_NO' => '',
            'SCBANK_IND' => '',
            'SUPCOUNTRY' => '',
            'BLLSRV_IND' => '',
            'REF_DOC_NO_LONG' => '',
            'DSCT_AMOUNT' => '',
            'PO_SUB_NO' => '',
            'PO_CHECKDG' => '',
            'PO_REF_NO' => '',
            'PAYEE_PAYER' => '',
            'PARTNER_BK' => '000'.$billing->partner_bank,
            'HOUSEBANKID' => $billing->house_bank,
            'ALLOC_NMBR' => '',
            'PAYMT_REF' => '',
            'INV_REF_NO' => '',
            'INV_YEAR' => '',
            'INV_REC_DATE' => '',
            'PLANNING_LEVEL' => '',
            'PLANNING_DATE' => '',
            'FIXEDTERMS' => '',
            'BUS_AREA' => '',
            'LOT_NUMBER' => '',
            'ITEM_TEXT' => $billing->perihal_claim,
            'J_1BNFTYPE' => '',
            'EU_TRIANG_DEAL' => '',
            'REPCOUNTRY' => '',
            'VAT_REG_NO' => '',
            'BUSINESS_PLACE' => '',
            'TAX_EXCH_RATE' => '',
            'GOODS_AFFECTED' => '',
            'RET_DUE_PROP' => '',
            'DELIV_POSTING' => '',
            'RETURN_POSTING' => '',
            'INV_TRAN' => '',
            'SIMULATION' => '',
            'J_1TPBUPL' => '',
            'SECCO' => '',
            'VATDATE' => '',
            'DE_CRE_IND' => '',
            'TRANS_DATE' => '',
        ];

        foreach( $billingDetail as $key => $rows ) {
            $i = $key + 1;
            $invDocItem = ('0000'.(0+($i*10)));
            // like 1 0 9x = sheetno di isi
            $ITEMDATA = [
                'INVOICE_DOC_ITEM' => $invDocItem,//$invDocItem,//'000010',20
                'PO_NUMBER' => $rows->po_no,//'3010002673',
                'PO_ITEM' => $rows->PO_ITEM,//'00010',
                'REF_DOC' => $rows->reference_document,//'5000042639',
                'REF_DOC_YEAR' => $rows->tahun_gr,//'2020',
                'REF_DOC_IT' => $rows->item_gr,
                'DE_CRE_IND' => '',
                'TAX_CODE' => $billing->ppn,//'V0',
                'TAXJURCODE' => '',
                'ITEM_AMOUNT' => $rows->amount,//20000
                'QUANTITY' => $rows->qty,//20
                'PO_UNIT' => $rows->unit,//ST
                'PO_UNIT_ISO' => '',
                'PO_PR_QNT' => '',
                'PO_PR_UOM' => '',
                'PO_PR_UOM_ISO' => '',
                'COND_TYPE' => '',
                'COND_ST_NO' => '',
                'COND_COUNT' => '',
                'SHEET_NO' => '',//ketika po service $rows->reference_document
                'ITEM_TEXT' => '',
                'FINAL_INV' => '',
                'SHEET_ITEM' => '',
                'GRIR_CLEAR_SRV' => '',
                'FREIGHT_VEN' => '',
                'CSHDIS_IND' => '',
                'RETENTION_DOCU_CURRENCY' => '',
                'RETENTION_PERCENTAGE' => '',
                'RETENTION_DUE_DATE' => '',
                'NO_RETENTION' => '',
                'VALUATION_TYPE' => '',
                'INV_RELATION' => '',
                'INV_ITM_ORIGIN' => '',
                'COND_COUNT_LONG' => '',
                'DEL_CREATE_DATE' => '',
            ];
            $params[0]['ITEMDATA'][$key] = $ITEMDATA;
        }

        if( $billing->calculate_tax == 0 ) {
            $TAXDATA = [
                'TAX_CODE' => $billing->ppn,
                'TAX_AMOUNT' => $billing->tax_amount,
                'TAX_BASE_AMOUNT' => $billing->dpp,
                'COND_TYPE' => '',
                'TAXJURCODE' => '',
                'TAXJURCODE_DEEP'=>'',
                'ITEMNO_TAX' => '',
                'TAX_AMOUNT_LOCAL' => '',
                'TAX_BASE_AMOUNT_LOCAL '=>'',
            ];
            
        }

        if( $billing->tipe_pph != '' ) {
            $taxType = \App\Models\MasterPph::getPphById($billing->tipe_pph);
            $WITHTAXDATA = [
                'SPLIT_KEY' => '00001',//klo tipe pa 0,1
                'WI_TAX_TYPE' => $taxType->withholding_tax_type,//dari master pph
                'WI_TAX_CODE' => $taxType->withholding_tax_code,//dari master pph
                'WI_TAX_BASE' => $billing->dpp,//
                'WI_TAX_AMT' => '',
                'WI_TAX_WITHHELD_AMT' => ''
            ];
        }

        $RETURN = [
            'TYPE' => '',
            'ID' => '',
            'NUMBER' => '',
            'MESSAGE' => '',
            'LOG_NO' => '',
            'LOG_MSG_NO' => '',
            'MESSAGE_V' => '',
            'MESSAGE_V2' => '',
            'MESSAGE_V3' => '',
            'MESSAGE_V4' => '',
            'PARAMETER' => '',
            'ROW' => '',
            'FIELD' => '',
            'SYSTEM' => '',
        ];

        $params[0]['HEADERDATA'] = $HEADER;
        $params[0]['TAXDATA'] = $TAXDATA;
        $params[0]['WITHTAXDATA'] = $WITHTAXDATA;
        $params[0]['RETURN'] = $RETURN;
        $result = $client->__soapCall('ZFM_WS_MIRO', $params, null, $header);
        if( $result->INVOICEDOCNUMBER != '' ) {
            $billing->document_no = $result->INVOICEDOCNUMBER;
            $billing->fiscal_year = $result->FISCALYEAR;
            $billing->status      = \App\Models\Vendor\Billing::ApprovedSpv;
            $billing->update();
            return true;
        } else {
            return false;
        }
    }
}