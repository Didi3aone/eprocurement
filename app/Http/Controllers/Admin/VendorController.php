<?php

namespace App\Http\Controllers\Admin;

use Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor;
use App\Models\Vendor\UserVendors;
use App\Models\Vendor\UserVendorsImport;
use App\Models\Vendor\UserVendorsImportBank;
use App\Models\Vendor\MasterVendorAccountGL;
use App\Models\Vendor\MasterVendorBankCountry;
use App\Models\Vendor\MasterVendorBankKeys;
use App\Models\Vendor\MasterVendorBPGroup;
use App\Models\Vendor\MasterVendorPlanningGroup;
use App\Models\Vendor\MasterVendorTitle;
use App\Models\Vendor\MasterVendorCountry;
use App\Models\Vendor\MasterVendorTermsOfPayment;
use App\Models\Vendor\VendorBPRoles;
use App\Models\Vendor\VendorCompanyData;
use App\Models\Vendor\VendorWithholdingTaxType;
use App\Models\Vendor\VendorPurchasingOrganization;
use App\Models\Vendor\VendorPartnerFunctions;
use App\Models\Vendor\VendorBankDetails;
use App\Models\Vendor\VendorTaxNumbers;
use App\Models\Vendor\VendorIdentificationNumbers;
use App\Models\Vendor\VendorEmail;
use App\Imports\VendorsImport;
use App\Exports\VendorExport;
use Gate, Exception;
use Symfony\Component\HttpFoundation\Response;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const bp_group_code_local = ['Z001','Z003'];

    public function index()
    {
        abort_if(Gate::denies('vendor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $vendors = Vendor::all();
        $vendors = UserVendors::select(
                        'vendors.*',
                        'master_vendor_bp_group.code as vendor_bp_group_code',
                        'master_vendor_bp_group.name as vendor_bp_group_name',
                        \DB::raw('CASE WHEN vendors.status = 0 THEN 0 ELSE 1 END AS status_')
                    )
                    ->join('master_vendor_bp_group', 'master_vendor_bp_group.id', 'vendors.vendor_bp_group_id')
                    ->orderBy('status_', 'asc')
                    ->orderBy('updated_at', 'desc')
                    // ->limit(10)
                    ->get();
        foreach ($vendors as $row) {
            $row->created_date = date('d M Y, H:i', strtotime($row->created_at));
            $row->updated_date = date('d M Y, H:i', strtotime($row->updated_at));
            $row->status_str = '<span class="badge badge-primary">Waiting For Approval</span>';
            if ($row->status==1)
                $row->status_str = '<span class="badge badge-success">Approved</span>';
            else if ($row->status==2)
                $row->status_str = '<span class="badge badge-danger">Rejected</span>';
        }

        return view('admin.vendors.index',compact('vendors'));
    }

    public function download()
    {
        try {
            \DB::beginTransaction();

            $export = (new VendorExport())->download('Data-Vendor-'.date('YmdHis').'.xlsx');

            UserVendors::where('is_export', 0)->update(['is_export' => 1]);

            \DB::commit();
            return $export;
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            return redirect()->route('admin.vendors')->with('error', 'Sorry! Something is wrong with this process!');
        }
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        
        $path = 'xls/';
        $file = $request->file('xls_file');

        if (!empty($file)) {
            $filename = $file->getClientOriginalName();

            $file->move($path, $filename);

            $real_filename = public_path($path . $filename);

            Artisan::call('import:vendor', ['filename' => $real_filename]);

            return redirect('admin/vendors')->with('error', 'Vendors imported failed');
        } else {
            return redirect('admin/vendors')->with('success', 'Vendors has been successfully imported');
        }
    }

    public function migrate()
    {
        ini_set('max_execution_time', 0);

        try {
            \DB::beginTransaction();

            $user_vendors_import = UserVendorsImport::select('*')
                                    ->where('has_migrate', 0)
                                    // ->whereIn('account_group', ['Z001', 'Z002', 'Z003', 'Z004'])
                                    // ->limit(1000)
                                    ->get();
                                    // ->count();
            // echo json_encode($user_vendors_import); die();
            foreach ($user_vendors_import as $row) {
                $user_vendors = UserVendors::where('code', $row->vendor)->get()->first();
                if (!$user_vendors) {
                    $is_local = in_array($row->account_group, self::bp_group_code_local);

                    $user_vendor = $this->insert_user_vendor($row);
                    $this->insert_vendor_bp_roles($user_vendor->id);
                    $this->insert_vendor_company_data($user_vendor->id, $is_local, $row->payment_terms);
                    $this->insert_vendor_withholding_tax_type($user_vendor->id);
                    $this->insert_vendor_purchasing_organization($user_vendor->id, $row->payment_terms);
                    $this->insert_vendor_partner_functions($user_vendor->id);
                    // $this->insert_vendor_bank_details($request, $user_vendor->id, $is_local);
                    $this->insert_vendor_tax_number($user_vendor->id, $row->tax_number_1);
                    $this->insert_vendor_identification_numbers($user_vendor->id, $is_local);
                    $vendor_id = $user_vendor->id;
                } else {
                    UserVendors::where('id', $user_vendors->id)->update(['email' => $row->email]);
                    $vendor_id = $user_vendors->id;
                }
                VendorEmail::create(['vendor_id' => $vendor_id, 'email' => $row->email]);
                UserVendorsImport::where('id', $row->id)->update(['has_migrate' => 1]);
            }

            \DB::commit();
            echo 'Success';
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    public function migrate_payment_terms()
    {
        ini_set('max_execution_time', 0);

        try {
            \DB::beginTransaction();

            $user_vendors_import = UserVendorsImport::select(
                                        \DB::raw('DISTINCT vendor'),
                                        'payment_terms',
                                        'id'
                                    )
                                    ->where('has_migrate', 2)
                                    ->limit(1000)
                                    ->get();
            // echo json_encode($user_vendors_import); die();
            foreach ($user_vendors_import as $row) {
                $user_vendors = UserVendors::where('code', $row->vendor)->get()->first();
                if (!$user_vendors) continue;
                UserVendors::where('id', $user_vendors->id)->update(['payment_terms' => $row->payment_terms]);
                VendorCompanyData::where('vendor_id', $user_vendors->id)->update(['payment_terms' => $row->payment_terms]);
                VendorPurchasingOrganization::where('vendor_id', $user_vendors->id)->update(['term_of_payment_key' => $row->payment_terms]);

                UserVendorsImport::where('id', $row->id)->update(['has_migrate' => 1]);
            }

            \DB::commit();
            echo 'Success';
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    public function migrate_bank()
    {
        try {
            \DB::beginTransaction();

            $user_vendors_import_bank = UserVendorsImportBank::select()
                                    ->where('has_migrate', 0)
                                    // ->limit(1000)
                                    ->get();
            // echo json_encode($user_vendors_import_bank); die();
            foreach ($user_vendors_import_bank as $row) {
                $user_vendors = UserVendors::where('code', $row->vendor)->get()->first();
                // dd($user_vendors);
                if (!$user_vendors) continue;
                VendorBankDetails::create([
                    'vendor_id' => $user_vendors->id,
                    'bank_country_key' => $row->bank_country,
                    'bank_keys' => $row->bank_key,
                    'account_no' => $row->bank_account,
                    // 'bank_details' => $row->reference_details,
                    'bank_details' => $row->bank_details,
                    'account_holder_name' => $row->account_holder,
                    'partner_bank' => $row->partner_bank,
                ]);

                UserVendorsImportBank::where('id', $row->id)->update(['has_migrate' => 1]);
            }

            \DB::commit();
            echo 'Success';
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    private function insert_user_vendor($row)
    {
        $vendor_title = MasterVendorTitle::where('name', $row->title)->get()->first();
        $vendor_title_id = $vendor_title->id ?? null;
        $vendor_bp_group = MasterVendorBPGroup::where('code', $row->account_group)->get()->first();
        $vendor_bp_group_id = $vendor_bp_group->id ?? null;

        $post = [];
        $post['code'] = $row->vendor;
        $post['vendor_title_id'] = $vendor_title_id;
        $post['vendor_bp_group_id'] = $vendor_bp_group_id;
        $post['specialize'] = $row->search_term;
        $post['company_name'] = $row->name;
        $post['city'] = $row->city;
        $post['postal_code'] = $row->postal_code;
        $post['country'] = $row->country;
        $post['street'] = $row->street;
        $post['street_2'] = $row->street_2;
        $post['street_3'] = $row->street_3;
        $post['street_4'] = $row->street_4;
        $post['street_5'] = $row->street_5;
        $post['language'] = 'EN';
        $post['office_telephone'] = $row->telephone_1;
        $post['telephone_2'] = $row->telephone_2;
        $post['office_fax'] = $row->fax_number;
        $post['name'] = $row->name;
        $post['email'] = $row->email;
        $post['payment_terms'] = $row->payment_terms;
        $post['status'] = 1;
        $post['is_export'] = 1;
        $do_insert = UserVendors::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_user_vendor');

        return $do_insert;
    }

    private function insert_vendor_bp_roles($vendor_id)
    {
        $bp_roles = ['FLVN01', 'FLVN00'];
        foreach ($bp_roles as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['bp_role'] = $value;
            $do_insert = VendorBPRoles::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_bp_roles');
        }

        return true;
    }

    private function insert_vendor_company_data($vendor_id, $is_local, $payment_terms)
    {
        $company_data = ['1100', '1200', '2100'];
        foreach ($company_data as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['company_code'] = $value;
            $post['account_gl'] = $is_local ? '2111011001' : '2111021001';
            $post['planning_group'] = $is_local ? 'A1' : 'A2';
            $post['payment_terms'] = $payment_terms;
            $do_insert = VendorCompanyData::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_company_data');
        }

        return true;
    }

    private function insert_vendor_withholding_tax_type($vendor_id)
    {
        $company_code = ['1100','1200'];
        foreach ($company_code as $value) {
            $withholding_tax_type = ['I1','I2','I3','I4','I5','I6','I8'];
            foreach ($withholding_tax_type as $value2) {
                $post = [];
                $post['vendor_id'] = $vendor_id;
                $post['company_code'] = $value;
                $post['withholding_tax_type'] = $value2;
                $do_insert = VendorWithholdingTaxType::create($post);
                if (!$do_insert) throw new Exception('Failed at insert_vendor_withholding_tax_type');
            }
        }

        return true;
    }

    private function insert_vendor_purchasing_organization($vendor_id, $payment_terms)
    {
        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['purchasing_organization'] = '0000';
        $post['order_currency'] = 'IDR';
        $post['term_of_payment_key'] = $payment_terms;
        $do_insert = VendorPurchasingOrganization::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_purchasing_organization');

        return true;
    }

    private function insert_vendor_partner_functions($vendor_id)
    {
        $partner_functions = ['RS','BA', 'LF'];
        foreach ($partner_functions as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['purchasing_organization'] = '0000';
            $post['partner_functions'] = $value;
            $do_insert = VendorPartnerFunctions::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_partner_functions');
        }

        return true;
    }

    private function insert_vendor_bank_details($request, $vendor_id, $is_local)
    {
        $bank_country_id = $request->input('bank_country_id');
        $bank_keys_id = $request->input('bank_keys_id');
        $bank_account_no = $request->input('bank_account_no');
        $bank_account_holder_name = $request->input('bank_account_holder_name');

        $bank_country_code = 'ID';
        $bank_country = MasterVendorBankCountry::find($bank_country_id);
        if ($bank_country) {
            $bank_country_code = $bank_country->code;
        }

        $bank_keys_ = 0;
        $bank_details = '';
        $bank_keys = MasterVendorBankKeys::find($bank_keys_id);
        if ($bank_keys) {
            $bank_keys_ = $bank_keys->key;
            $bank_details = $bank_keys->name;
        }

        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['bank_country_key'] = $bank_country_code;
        $post['bank_keys'] = $bank_keys_;
        $post['account_no'] = $bank_account_no;
        if (!$is_local)
            $post['iban'] = '';
        $post['bank_details'] = $bank_details;
        $post['account_holder_name'] = $bank_account_holder_name;
        $do_insert = VendorBankDetails::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_bank_details');

        return true;
    }

    private function insert_vendor_tax_number($vendor_id, $tax_numbers)
    {
        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['tax_numbers_category'] = 'ID';
        $post['tax_numbers'] = $tax_numbers;
        $do_insert = VendorTaxNumbers::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_tax_number');

        return true;
    }

    private function insert_vendor_identification_numbers($vendor_id, $is_local)
    {
        $identification_type = ['ZBENST', 'ZBENTY', 'ZCHARG', 'ZRGTYP'];
        $identification_numbers = ['1', '2', 'CRED', 'E0N'];
        $identification_count = count($identification_type);
        if ($is_local) $identification_count--;
        for ($i=0; $i < $identification_count; $i++) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['identification_type'] = $identification_type[$i];
            $post['identification_numbers'] = $identification_numbers[$i];
            $do_insert = VendorIdentificationNumbers::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_identification_numbers');
        }

        return true;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('vendor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $terms_of_payment = MasterVendorTermsOfPayment::get();

        $vendor_title = MasterVendorTitle::get();
        $vendor_bank_keys = MasterVendorBankKeys::get();
        $vendor_bank_country = MasterVendorBankCountry::get();
        $vendor_bp_group = MasterVendorBPGroup::get();
        $vendor_account_gl = MasterVendorAccountGL::get();
        $vendor_planning_group = MasterVendorPlanningGroup::get();
        $vendor_country = MasterVendorCountry::get();

        return view('admin.vendors.create', compact('terms_of_payment','vendor_title', 'vendor_bank_keys', 'vendor_bank_country', 'vendor_bp_group', 'vendor_account_gl', 'vendor_planning_group', 'vendor_country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Requset validate
        // $email = $request->input('email');
        // $check_email = UserVendors::where('email', $email)->get()->first();
        // if ($check_email) {
        //     return redirect()->route('admin.vendors.index')
        //             ->with('error', 'Email has been registered');
        // }
        $password = $request->input('password');
        $c_password = $request->input('c_password');
        if ($password != $c_password) {
            return redirect()->route('admin.vendors.index')
                    ->with('error', 'Confirm password must be same');
        }

        // Generate vendor code
        $vendor_code = 0;
        $vendor_code_ = null;
        $vendor_bp_group_id = $request->input('vendor_bp_group_id');
        $vendor_bp_group = MasterVendorBPGroup::find($vendor_bp_group_id);
        if ($vendor_bp_group) {
            $vendor_code = $vendor_bp_group->code;
            $count_id = UserVendors::count();
            $vendor_code_ = sprintf('%06d', $count_id+1);
            $vendor_code_ = substr($vendor_code,-1).$vendor_code_;
        }
        $is_local = in_array($vendor_code, self::bp_group_code_local);

        try {
            \DB::beginTransaction();

            $user_vendor = $this->_insert_user_vendor($request, $vendor_code_);
            $this->_insert_vendor_bp_roles($user_vendor->id);
            $this->_insert_vendor_company_data($user_vendor->id, $is_local);
            $this->_insert_vendor_withholding_tax_type($user_vendor->id);
            $this->_insert_vendor_purchasing_organization($user_vendor->id);
            $this->_insert_vendor_partner_functions($user_vendor->id);
            $this->_insert_vendor_bank_details($request, $user_vendor->id, $is_local);
            $this->_insert_vendor_tax_number($request, $user_vendor->id);
            $this->_insert_vendor_identification_numbers($user_vendor->id, $is_local);
            $this->_insert_vendor_email($request, $user_vendor->id, $is_local);

            \DB::commit();
            return redirect()->route('admin.vendors.index')->with('success', 'cruds.vendors.alert_success_insert');
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            return redirect()->route('admin.vendors.index')->with('error', 'cruds.vendors.alert_error_insert');
        }
    }

    private function _insert_user_vendor($request, $vendor_code_)
    {
        $vendor_title_id = $request->input('vendor_title_id');
        $vendor_bp_group_id = $request->input('vendor_bp_group_id');
        $specialize = $request->input('specialize'); // search_term_1
        $company_name = $request->input('company_name'); // search_term_2
        $street = $request->input('street');
        $different_city = $request->input('different_city') ?? "-";
        $city = $request->input('city');
        $country = $request->input('country');
        $company_web = $request->input('company_web');
        $postalCode = $request->input('postal_code');
        $street = $request->input('street'); // address
        $street_2 = $request->input('street_2');
        $street_3 = $request->input('street_3');
        $street_4 = $request->input('street_4');
        $street_5 = $request->input('street_5');
        $language = 'EN';
        $office_telephone = $request->input('office_telephone');
        $telephone_2 = $request->input('telephone_2');
        $telephone_3 = $request->input('telephone_3');
        $office_fax = $request->input('office_fax');
        $fax_2 = $request->input('fax_2');
        $name = $request->input('name');
        $email = $request->input('email');
        // $email = $request->input('email');
        $is_default = $request->input('is_default');
        $index = 0;
        foreach ($is_default as $i => $row) {
            if ($row=='1') $index = $i;
        }
        $email_default = $email[$index];
        $password = $request->input('password');
        $status = $request->input('status');
        $terms_of_payment_id = $request->input('terms_of_payment_id');
        $terms_of_payment = MasterVendorTermsOfPayment::findOrFail($terms_of_payment_id);

        $post = [];
        $post['code'] = $vendor_code_;
        $post['vendor_title_id'] = $vendor_title_id;
        $post['vendor_bp_group_id'] = $vendor_bp_group_id;
        $post['specialize'] = $specialize;
        $post['company_name'] = $company_name;
        $post['different_city'] = $different_city;
        $post['city'] = $city;
        $post['postal_code'] = $postalCode;
        $post['country'] = $country;
        if ($company_web)
            $post['company_web'] = $company_web;
        $post['street'] = $street;
        $post['street_2'] = $street_2;
        $post['street_3'] = $street_3;
        $post['street_4'] = $street_4;
        $post['street_5'] = $street_5;
        $post['language'] = $language;
        $post['office_telephone'] = $office_telephone;
        $post['telephone_2'] = $telephone_2;
        $post['telephone_3'] = $telephone_3; 
        $post['office_fax'] = $office_fax;
        $post['fax_2'] = $fax_2;
        $post['name'] = $name;
        $post['email'] = $email_default;
        $post['password'] = bcrypt($password);
        $post['status'] = $status;
        $post['payment_terms'] = $terms_of_payment->code;
        $do_insert = UserVendors::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_user_vendor');

        return $do_insert;
    }

    private function _insert_vendor_bp_roles($vendor_id)
    {
        $bp_roles = ['FLVN01', 'FLVN00'];
        foreach ($bp_roles as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['bp_role'] = $value;
            $do_insert = VendorBPRoles::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_bp_roles');
        }

        return true;
    }

    private function _insert_vendor_company_data($vendor_id, $is_local)
    {
        $company_data = ['1100', '1200', '2100'];
        foreach ($company_data as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['company_code'] = $value;
            $post['account_gl'] = $is_local ? '2111011001' : '2111021001';
            $post['planning_group'] = $is_local ? 'A1' : 'A2';
            $do_insert = VendorCompanyData::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_company_data');
        }

        return true;
    }

    private function _insert_vendor_withholding_tax_type($vendor_id)
    {
        $company_code = ['1100','1200'];
        foreach ($company_code as $value) {
            $withholding_tax_type = ['I1','I2','I3','I4','I5','I6','I8'];
            foreach ($withholding_tax_type as $value2) {
                $post = [];
                $post['vendor_id'] = $vendor_id;
                $post['company_code'] = $value;
                $post['withholding_tax_type'] = $value2;
                $do_insert = VendorWithholdingTaxType::create($post);
                if (!$do_insert) throw new Exception('Failed at insert_vendor_withholding_tax_type');
            }
        }

        return true;
    }

    private function _insert_vendor_purchasing_organization($vendor_id)
    {
        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['purchasing_organization'] = '0000';
        $post['order_currency'] = 'IDR';
        $do_insert = VendorPurchasingOrganization::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_purchasing_organization');

        return true;
    }

    private function _insert_vendor_partner_functions($vendor_id)
    {
        $partner_functions = ['RS','BA', 'LF'];
        foreach ($partner_functions as $value) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['purchasing_organization'] = '0000';
            $post['partner_functions'] = $value;
            $do_insert = VendorPartnerFunctions::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_partner_functions');
        }

        return true;
    }

    private function _insert_vendor_bank_details($request, $vendor_id, $is_local)
    {
        $bank_country_id = $request->input('bank_country_id');
        $bank_keys_id = $request->input('bank_keys_id');
        $bank_account_no = $request->input('bank_account_no');
        $bank_account_holder_name = $request->input('bank_account_holder_name');

        $bank_country_code = 'ID';
        $bank_country = MasterVendorBankCountry::find($bank_country_id);
        if ($bank_country) {
            $bank_country_code = $bank_country->code;
        }

        $bank_keys_ = 0;
        $bank_details = '';
        $bank_keys = MasterVendorBankKeys::find($bank_keys_id);
        if ($bank_keys) {
            $bank_keys_ = $bank_keys->key;
            $bank_details = $bank_keys->name;
        }

        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['bank_country_key'] = $bank_country_code;
        $post['bank_keys'] = $bank_keys_;
        $post['account_no'] = $bank_account_no;
        if (!$is_local)
            $post['iban'] = '';
        $post['bank_details'] = $bank_details;
        $post['account_holder_name'] = $bank_account_holder_name;
        $do_insert = VendorBankDetails::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_bank_details');

        return true;
    }

    private function _insert_vendor_tax_number($request, $vendor_id)
    {
        $tax_numbers = $request->input('tax_numbers');

        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['tax_numbers_category'] = 'ID';
        $post['tax_numbers'] = $tax_numbers;
        $do_insert = VendorTaxNumbers::create($post);
        if (!$do_insert) throw new Exception('Failed at insert_vendor_tax_number');

        return true;
    }

    private function _insert_vendor_identification_numbers($vendor_id, $is_local)
    {
        $identification_type = ['ZBENST', 'ZBENTY', 'ZCHARG', 'ZRGTYP'];
        $identification_numbers = ['1', '2', 'CRED', 'E0N'];
        $identification_count = count($identification_type);
        if ($is_local) $identification_count--;
        for ($i=0; $i < $identification_count; $i++) {
            $post = [];
            $post['vendor_id'] = $vendor_id;
            $post['identification_type'] = $identification_type[$i];
            $post['identification_numbers'] = $identification_numbers[$i];
            $do_insert = VendorIdentificationNumbers::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_identification_numbers');
        }

        return true;
    }

    private function _insert_vendor_email($request, $vendor_id)
    {
        $email = $request->input('email');
        $is_default = $request->input('is_default');

        for ($i=0; $i < count($email); $i++) { 
            if ($email[$i]==null) continue;
            $post = [];
            $post['vendor_id'] = $id;
            $post['email'] = $email[$i];
            $post['is_default'] = $is_default[$i] ?? 0;
            $do_insert = VendorEmail::create($post);
            if (!$do_insert) throw new Exception('Failed at insert_vendor_email');
        }

        return true;
    }

    public function setPassword (Request $request)
    {
        if ($request->get('password') == $request->get('password_confirmation')) {
            $id = $request->get('vendor_id');

            $model = Vendor::find($id);
            $model->password = \Hash::make($request->get('password'));
            $model->save();
    
            return redirect()->route('admin.vendors.index')->with('success', 'Password has been set');
        } else
            return redirect()->route('admin.vendors.index')->with('error', 'Password confirmation doesnot match');
    }

    public function addBank (Request $request)
    {
        $vendor_id = $request->input('vendor_id');
        $bank_country_id = $request->input('bank_country_id');
        $bank_keys_id = $request->input('bank_keys_id');
        $bank_account_no = $request->input('bank_account_no');
        $bank_account_holder_name = $request->input('bank_account_holder_name');

        $bank_country_code = 'ID';
        $bank_country = MasterVendorBankCountry::find($bank_country_id);
        if ($bank_country) {
            $bank_country_code = $bank_country->code;
        }

        $bank_keys_ = 0;
        $bank_details = '';
        $bank_keys = MasterVendorBankKeys::find($bank_keys_id);
        if ($bank_keys) {
            $bank_keys_ = $bank_keys->key;
            $bank_details = $bank_keys->name;
        }

        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['bank_country_key'] = $bank_country_code;
        $post['bank_keys'] = $bank_keys_;
        $post['account_no'] = $bank_account_no;
        $post['bank_details'] = $bank_details;
        $post['account_holder_name'] = $bank_account_holder_name;
        $do_insert = VendorBankDetails::create($post);
        if ($do_insert) {
            return redirect('admin/vendors/'.$vendor_id.'/edit')->with('success', 'Bank Details has been added');
        } else {
            return redirect('admin/vendors/'.$vendor_id.'/edit')->with('error', 'Bank Details failed added');
        }
    }

    public function deleteBank(Request $request)
    {
        $vendor_bank_id = $request->input('vendor_bank_id');
        $vendor_bank = VendorBankDetails::find($vendor_bank_id);
        if (!$vendor_bank)
            return redirect()->back();

        $do_delete = VendorBankDetails::where('id', $vendor_bank_id)->delete();

        if ($do_insert) {
            return redirect('admin/vendors/'.$vendor_bank->vendor_id.'/edit')->with('success', 'Bank Details has been added');
        } else {
            return redirect('admin/vendors/'.$vendor_bank->vendor_id.'/edit')->with('error', 'Bank Details failed added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('vendor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $vendors = Vendor::findOrFail($id);
        $vendors = UserVendors::findOrFail($id);
        $term_of_payment = MasterVendorTermsOfPayment::find($vendors->terms_of_payment_key_id);
        $vendors->terms_of_payment = $term_of_payment->description ?? null;

        return view('admin.vendors.show', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('vendor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vendors = UserVendors::find($id);
        if ($vendors) {
            $vendor_tax = VendorTaxNumbers::where('vendor_id', $vendors->id)->first();
            if ($vendor_tax) $vendors->tax_numbers = $vendor_tax->tax_numbers;
            $email_is_active = false;
            $vendor_email = VendorEmail::where('vendor_id', $vendors->id)->get();
            foreach ($vendor_email as $row) {
                if ($row->is_default==1) $email_is_active = true;
                if ($row->email==$vendors->email) {
                    $row->is_default = 1;
                    $email_is_active = true;
                }
            }
            if (!$email_is_active) {
                $vendor_email_['id'] = null;
                $vendor_email_['vendor_id'] = $vendors->id;
                $vendor_email_['email'] = $vendors->email;
                $vendor_email_['is_default'] = 1;
                $vendor_email[] = (object) $vendor_email_;
            }
            for ($i=count($vendor_email); $i < 10; $i++) { 
                $vendor_email_['id'] = null;
                $vendor_email_['vendor_id'] = $vendors->id;
                $vendor_email_['email'] = '';
                $vendor_email_['is_default'] = 0;
                $vendor_email[] = (object) $vendor_email_;
            }
            $vendors->vendor_email = $vendor_email;
            $vendor_bank = VendorBankDetails::where('vendor_id', $vendors->id)->get();
            $vendors->vendor_bank = $vendor_bank;
        }
        $terms_of_payment = MasterVendorTermsOfPayment::get();

        $vendor_title = MasterVendorTitle::get();
        $vendor_bank_keys = MasterVendorBankKeys::get();
        $vendor_bank_country = MasterVendorBankCountry::get();
        $vendor_bp_group = MasterVendorBPGroup::get();
        $vendor_account_gl = MasterVendorAccountGL::get();
        $vendor_planning_group = MasterVendorPlanningGroup::get();
        $vendor_country = MasterVendorCountry::get();

        return view('admin.vendors.edit', compact('vendors','terms_of_payment','vendor_title', 'vendor_bank_keys', 'vendor_bank_country', 'vendor_bp_group', 'vendor_account_gl', 'vendor_planning_group', 'vendor_country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = $request->input('status');
        $terms_of_payment_id = $request->input('terms_of_payment_id');

        $name = $request->input('name');
        $vendor_title_id = $request->input('vendor_title_id');
        $vendor_bp_group_id = $request->input('vendor_bp_group_id');
        $specialize = $request->input('specialize');
        $company_name = $request->input('company_name');
        $street = $request->input('street');
        $street_2 = $request->input('street_2');
        $street_3 = $request->input('street_3');
        $street_4 = $request->input('street_4');
        $street_5 = $request->input('street_5');
        $postal_code = $request->input('postal_code');
        $city = $request->input('city');
        $country = $request->input('country');
        $company_web = $request->input('company_web');
        $office_telephone = $request->input('office_telephone');
        $telephone_2 = $request->input('telephone_2');
        $telephone_3 = $request->input('telephone_3');
        $office_fax = $request->input('office_fax');
        $fax_2 = $request->input('fax_2');
        $tax_numbers = $request->input('tax_numbers');
        $different_city = $request->input('different_city') ?? "-";

        $vendor_email_id = $request->input('vendor_email_id');
        $email = $request->input('email');
        $is_default = $request->input('is_default');
        $index = 0;
        foreach ($is_default as $i => $row) {
            if ($row=='1') $index = $i;
        }
        $email_default = $email[$index];

        $terms_of_payment = MasterVendorTermsOfPayment::findOrFail($terms_of_payment_id);
        $user_vendors = UserVendors::findOrFail($id);

        $vendor_bank_id = $request->input('vendor_bank_id');
        $bank_country_key = $request->input('bank_country_key');
        $bank_keys = $request->input('bank_keys');
        $bank_account_no = $request->input('bank_account_no');
        $bank_account_holder_name = $request->input('bank_account_holder_name');

        try {
            \DB::beginTransaction();

            $do_update = true;

            $post_update = [];
            $post_update['terms_of_payment_key_id'] = null; //$terms_of_payment_id,
            $post_update['payment_terms'] = $terms_of_payment->code;
            $post_update['status'] = $status;
            $post_update['vendor_title_id'] = $vendor_title_id;
            $post_update['vendor_bp_group_id'] = $vendor_bp_group_id;
            $post_update['specialize'] = $specialize;
            $post_update['company_name'] = $company_name;
            $post_update['different_city'] = $different_city;
            $post_update['city'] = $city;
            $post_update['postal_code'] = $postal_code;
            $post_update['country'] = $country;
            if ($company_web)
                $post_update['company_web'] = $company_web;
            $post_update['street'] = $street;
            $post_update['street_2'] = $street_2;
            $post_update['street_3'] = $street_3;
            $post_update['street_4'] = $street_4;
            $post_update['street_5'] = $street_5;
            $post_update['office_telephone'] = $office_telephone;
            $post_update['telephone_2'] = $telephone_2;
            $post_update['telephone_3'] = $telephone_3; 
            $post_update['office_fax'] = $office_fax;
            $post_update['fax_2'] = $fax_2;
            $post_update['name'] = $name;
            $post_update['email'] = $email_default;
            $do_update = $do_update && UserVendors::where('id', $id)->update($post_update);

            $post_update = [];
            $post_update['tax_numbers'] = $tax_numbers;
            $do_update = $do_update && VendorTaxNumbers::where('vendor_id', $id)->update($post_update);

            $post_update = [];
            $post_update['payment_terms'] = $terms_of_payment->code;
            $do_update = $do_update && VendorCompanyData::where('vendor_id', $id)->update($post_update);

            $post_update = [];
            $post_update['term_of_payment_key'] = $terms_of_payment->code;
            $do_update = $do_update && VendorPurchasingOrganization::where('vendor_id', $id)->update($post_update);

            for ($i=0; $i < count($email); $i++) { 
                $post = [];
                $post['vendor_id'] = $id;
                $post['email'] = $email[$i];
                $post['is_default'] = $is_default[$i] ?? 0;
                if ($vendor_email_id[$i]) {
                    $do_update = $do_update && VendorEmail::where('id', $vendor_email_id[$i])->update($post);
                } else {
                    if ($email[$i])
                        $do_update = $do_update && VendorEmail::create($post);
                }
            }

            for ($i=0; $i < count($vendor_bank_id); $i++) { 
                $bank_keys_ = 0;
                $bank_details = '';
                $vendor_bank_keys = MasterVendorBankKeys::find($bank_keys[$i]);
                if ($vendor_bank_keys) {
                    $bank_keys_ = $vendor_bank_keys->key;
                    $bank_details = $vendor_bank_keys->name;
                }

                $post = [];
                $post['bank_country_key'] = $bank_country_key[$i];
                $post['bank_keys'] = $bank_keys_;
                $post['account_no'] = $bank_account_no[$i];
                $post['bank_details'] = $bank_details;
                $post['account_holder_name'] = $bank_account_holder_name[$i];
                $do_update = $do_update && VendorBankDetails::where('id', $vendor_bank_id[$i])->update($post);
            }

            if (!$do_update) throw new Exception('Invalid request');
            
            \DB::commit();
            return redirect()->route('admin.vendors.index')->with('status', trans('cruds.vendors.alert_success_update'));
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->route('admin.vendors.index')->with('error', trans('cruds.vendors.alert_error_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('vendor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = Vendor::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Vendor deleted successfully";
        } else {
            $success = true;
            $message = "Vendor not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function getVendor(Request $request)
    {
        $vendor = Vendor::where('code', $request->code)->get();

        // $data = [];
        // foreach( $vendor as $row ) {
        //     $data[$row->code] = $row->code." - ".$row->name;
        // }

        return \response()->json($vendor, 200);
    }
}
