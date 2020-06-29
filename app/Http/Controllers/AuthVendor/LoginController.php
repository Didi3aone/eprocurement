<?php

namespace App\Http\Controllers\AuthVendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Vendor;
use App\Models\Vendor\MasterVendorAccountGL;
use App\Models\Vendor\MasterVendorBankCountry;
use App\Models\Vendor\MasterVendorBankKeys;
use App\Models\Vendor\MasterVendorBPGroup;
use App\Models\Vendor\MasterVendorPlanningGroup;
use App\Models\Vendor\MasterVendorTitle;
use App\Models\Vendor\UserVendors;
use App\Models\Vendor\VendorBPRoles;
use App\Models\Vendor\VendorCompanyData;
use App\Models\Vendor\VendorWithholdingTaxType;
use App\Models\Vendor\VendorPurchasingOrganization;
use App\Models\Vendor\VendorPartnerFunctions;
use App\Models\Vendor\VendorBankDetails;
use App\Models\Vendor\VendorTaxNumbers;
use App\Models\Vendor\VendorIdentificationNumbers;
use App\Models\Vendor\MasterVendorCountry;

use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    const bp_group_code_local = ['Z001','Z003'];
    
    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('authVendor.login');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required:email',
            'password' => 'required'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $model = Vendor::where('email', $request->email)->first();

        if (empty($model))
            return redirect()->route('vendor.login')->with('error', trans('global.vendor_not_found'));
            
        if ($model->status == 0)
            return redirect()->route('vendor.login')->with('error', trans('validation.vendor_not_validate'));

        if (Auth::guard('vendor')->attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('vendor.home'));
        }

        return redirect()->back()->withInputs($request->only('email'));
    }

    public function showRegisterForm ()
    {
        $vendor_title = MasterVendorTitle::get();
        $vendor_bank_keys = MasterVendorBankKeys::get();
        $vendor_bank_country = MasterVendorBankCountry::get();
        $vendor_bp_group = MasterVendorBPGroup::get();
        $vendor_account_gl = MasterVendorAccountGL::get();
        $vendor_planning_group = MasterVendorPlanningGroup::get();
        $vendor_country = MasterVendorCountry::get();

        return view('authVendor.register', compact('vendor_title', 'vendor_bank_keys', 'vendor_bank_country', 'vendor_bp_group', 'vendor_account_gl', 'vendor_planning_group', 'vendor_country'));
    }

    public function register (Request $request)
    {
        // Requset validate
        $email = $request->input('email');
        $check_email = UserVendors::where('email', $email)->get()->first();
        if ($check_email) {
            return redirect()->route('vendor.register')
                    ->with('error', 'Email has been registered');
        }
        $password = $request->input('password');
        $c_password = $request->input('c_password');
        if ($password != $c_password) {
            return redirect()->route('vendor.register')
                    ->with('error', 'Confirm password must be same');
        }
        $agreement = $request->input('agreement');
        if (!$agreement) {
            return redirect()->route('vendor.register')
                    ->with('error', 'Agreement is required');
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

            $user_vendor = $this->insert_user_vendor($request, $vendor_code_);
            $this->insert_vendor_bp_roles($user_vendor->id);
            $this->insert_vendor_company_data($user_vendor->id, $is_local);
            $this->insert_vendor_withholding_tax_type($user_vendor->id);
            $this->insert_vendor_purchasing_organization($user_vendor->id);
            $this->insert_vendor_partner_functions($user_vendor->id);
            $this->insert_vendor_bank_details($request, $user_vendor->id, $is_local);
            $this->insert_vendor_tax_number($request, $user_vendor->id);
            $this->insert_vendor_identification_numbers($user_vendor->id, $is_local);

            \DB::commit();
            return redirect()->route('vendor.login')->with('success', 'Register success');
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            return redirect()->route('vendor.register')->with('error', 'Sorry! Something is wrong with this process!');
        }
    }

    private function insert_user_vendor($request, $vendor_code_)
    {
        $vendor_title_id = $request->input('vendor_title_id');
        $vendor_bp_group_id = $request->input('vendor_bp_group_id');
        $specialize = $request->input('specialize'); // search_term_1
        $company_name = $request->input('company_name'); // search_term_2
        $street = $request->input('street');
        $different_city = $request->input('different_city');
        $city = $request->input('city');
        $country = $request->input('country');
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
        $email_2 = $request->input('email_2');
        $password = $request->input('password');
        $status = 0;

        $post = [];
        $post['code'] = $vendor_code_;
        $post['vendor_title_id'] = $vendor_title_id;
        $post['vendor_bp_group_id'] = $vendor_bp_group_id;
        $post['specialize'] = $specialize;
        $post['company_name'] = $company_name;
        $post['street'] = $street;
        $post['different_city'] = $different_city;
        $post['city'] = $city;
        $post['postal_code'] = $postalCode;
        $post['country'] = $country;
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
        $post['email'] = $email;
        $post['email_2'] = $email_2;
        $post['password'] = bcrypt($password);
        $post['status'] = $status;
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

    private function insert_vendor_company_data($vendor_id, $is_local)
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

    private function insert_vendor_purchasing_organization($vendor_id)
    {
        $post = [];
        $post['vendor_id'] = $vendor_id;
        $post['purchasing_organization'] = '0000';
        $post['order_currency'] = 'IDR';
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

    private function insert_vendor_tax_number($request, $vendor_id)
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

    // not used
    public function register_old (Request $request)
    {
        $model = new Vendor;
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->password = bcrypt($request->input('password'));
        $model->company_type = 1;
        $model->company_from = 1;
        $model->npwp = $request->input('npwp');
        $model->country_id = 1;
        $model->province_id = 1;
        $model->regencies_id = 1;
        $model->district_id = 1;
        $model->address = $request->input('address');
        $model->specialize = $request->input('specialize');
        $model->company_name = $request->input('company_name');
        $model->zip_code = $request->input('zip_code');
        $model->code_area = $request->input('code_area');
        $model->pkp = $request->input('pkp');
        $model->office_phone = $request->input('office_phone');
        $model->office_fax = $request->input('office_fax');
        $model->phone = $request->input('phone');
        $model->status = 0;
        $model->save();

        return redirect()->route('vendor.login');
    }

    public function logout ()
    {
        if (Auth::guard('vendor')->check()) {
            Auth::guard('vendor')->logout();
        }
    
        return redirect('vendor/login');
    }
}
