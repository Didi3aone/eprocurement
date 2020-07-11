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
        return (new VendorExport())->download('Data-Vendor-'.date('YmdHis').'.xlsx');
    }

    public function import(Request $request)
    {
        // abort_if(Gate::denies('vendor_import_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
                                    ->whereIn('account_group', ['Z001', 'Z002', 'Z003', 'Z004'])
                                    ->limit(1000)
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
                                    ->limit(1000)
                                    ->get();
            // echo json_encode($user_vendors_import_bank); die();
            foreach ($user_vendors_import_bank as $row) {
                $user_vendors = UserVendors::where('code', $row->vendor)->get()->first();
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

        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendors = Vendor::create($request->all());

        return redirect()->route('admin.vendors.index')->with('status', trans('cruds.vendors.alert_success_insert'));
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

        // $vendors = Vendor::findOrFail($id);
        $vendors = UserVendors::findOrFail($id);
        $terms_of_payment = MasterVendorTermsOfPayment::get();

        return view('admin.vendors.edit', compact('vendors','terms_of_payment'));
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
        $terms_of_payment = MasterVendorTermsOfPayment::findOrFail($terms_of_payment_id);
        $user_vendors = UserVendors::findOrFail($id);

        try {
            \DB::beginTransaction();

            $do_update = true;
            $do_update = $do_update && UserVendors::where('id', $id)
                                        ->update([
                                            'terms_of_payment_key_id' => null, //$terms_of_payment_id,
                                            'payment_terms' => $terms_of_payment->code,
                                            'status' => $status
                                        ]);
            $do_update = $do_update && VendorCompanyData::where('vendor_id', $id)
                                        ->update([
                                            'payment_terms' => $terms_of_payment->code
                                        ]);
            $do_update = $do_update && VendorPurchasingOrganization::where('vendor_id', $id)
                                        ->update([
                                            'term_of_payment_key' => $terms_of_payment->code
                                        ]);
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
