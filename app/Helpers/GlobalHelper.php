<?php
    use Carbon\Carbon;
    use App\Models\employeeApps\User as u;
    use App\Models\employeeApps\ConfigurationApp;
    use App\Models\Vendor\QuotationApproval;
    use App\Mail\enesisApprovalAcpMail;
    use App\Models\AcpTable;
    use App\Models\AcpTableDetail;
    use App\Models\AcpTableMaterials;

    function configEmailNotification()
    {
        return ConfigurationApp::where('name','notification_email')->first();
    }

    function getEmailLocal($nik)
    {
        return u::where('nik',$nik)->first();
    }

    function getProfileLocal($nik)
    {
        return u::where('nik',$nik)->first();
    }

    function getDepartmentByranking()
    {
        return \App\Models\OrangeHrm\Department::
                join('organization_level_tbl','organization_level_tbl.org_level_no','=','organization_unit_tbl.org_level_no')
                ->where('organization_level_tbl.ranking',3)
                ->whereDate('organization_unit_tbl.valid_to','>=',date('Y-m-d'))
                ->groupBy(
                    'organization_unit_tbl.org_id',
                    'organization_unit_tbl.name',
                    'organization_unit_tbl.company_id',
                    'organization_level_tbl.ranking'
                )
                ->select('organization_unit_tbl.org_id',
                        'organization_unit_tbl.name',
                        'organization_unit_tbl.company_id',
                        'organization_level_tbl.ranking')
                ->distinct('organization_unit_tbl.org_id')
                ->get();
    }

    function getZigZagDepartment($nik)
    {
        return \App\Models\OrangeHrm\Employee_tbl::join('person_tbl','person_tbl.person_id','=','employee_tbl.employee_id')
                            ->join('employee_organization_tbl','employee_organization_tbl.employee_id','=','employee_tbl.employee_id')
                            ->join('organization_unit_tbl','organization_unit_tbl.org_id','=','employee_organization_tbl.org_id')
                            ->join('employment_period_tbl','employment_period_tbl.employee_id','=','employee_tbl.employee_id')
                            ->join('emp_grade_interval_tbl','emp_grade_interval_tbl.employee_id','=','employee_tbl.employee_id')
                            ->join('emp_work_location_tbl','emp_work_location_tbl.employee_id','=','employee_tbl.employee_id')
                            ->whereDate('employee_organization_tbl.valid_to','>',date('Y-m-d'))
                            ->whereDate('employment_period_tbl.valid_to','>',date('Y-m-d'))
                            ->where('employee_tbl.employee_id', $nik)
                            ->where(function($q) {
                                $q->where('employee_tbl.company_id','=',\DB::raw('organization_unit_tbl.company_id'));
                            })->groupBy('employee_tbl.employee_id', 
                                'employee_tbl.company_id', 
                                'employee_organization_tbl.org_id',
                                'person_tbl.display_name',
                                'person_tbl.person_id',
                                'employee_organization_tbl.company_id',
                                'emp_grade_interval_tbl.grade_id',
                                'emp_work_location_tbl.work_location'
                            )
                            ->select(
                                \DB::raw("sp_get_department_id ( employee_tbl.company_id, employee_organization_tbl.org_id, ( 'now' :: TEXT ) :: DATE ) AS department"),
                                "person_tbl.display_name",
                                "employee_tbl.company_id",
                                "person_tbl.person_id",
                                "employee_organization_tbl.org_id",
                                'emp_grade_interval_tbl.grade_id',
                                'emp_work_location_tbl.work_location'
                            )
                            // ->havingRaw("sp_get_department_id ( employee_tbl.company_id, employee_organization_tbl.org_id, ( 'now' :: TEXT ) :: DATE ) = '$dept'")
                            ->first();
    }

    function getHRManagerByCompanyId($company_id)
    {
        $company_id = "HR_".$company_id;

        return \App\Models\OrangeHrm\ConfigurationApp::where('name', $company_id)
            ->first();
    }

    function getSpv($employee_id)
    {
        return \App\Models\OrangeHrm\SuperiorUser::where('employee_id', $employee_id)
            ->join('person_tbl', 'person_tbl.person_id', '=', 'employee_supervisor_tbl.supervisor_id')
            ->whereDate('employee_supervisor_tbl.valid_to', '>=', date('Y-m-d'))
            ->first();
    }

    function getCLevelByDept($dept)
    {
        $cLevel = \App\Models\OrangeHrm\MasterCLevelDetail::join('master_c_levels','master_c_levels.id','=','master_c_level_details.m_chief_id')
            ->where('master_c_level_details.code', $dept)
            ->first();

        return $cLevel;
    }

    function getHistoryPo($material_id)
    {
        $data = \App\Models\PurchaseOrdersDetail::where('material_id', $material_id)->get();
        return $data;
    }

    //ref https://stackoverflow.com/questions/2476789/how-to-get-the-first-word-of-a-sentence-in-php
    function split_name($name) {
        $arr = explode(' ',trim($name));
        return $arr[0];
    }

    // If they did not pass the 2nd func argument, then we will use an arbitrary value in the $arr.
    // By using func_num_args() to test for this, we can properly support testing for an array filled with nulls, if desired.
    // ie isHomogenous([null, null], null) === true
    // ref https://stackoverflow.com/questions/10560658/check-if-all-values-in-array-are-the-same
    //author : didi
    function checkArraySame(array $arr, $testValue = null) 
    {
        
        $testValue = func_num_args() > 1 ? $testValue : current($arr);
        foreach ($arr as $val) {
            if ($testValue !== $val) {
                return false;
            }
        }
        return true;
    }
    
    //metode approval barbar
    // biar cpet kelar dibayar 
    // puyeng aink
    function saveApprovals($assProc, $quotation_id, $tingkat,$type, $isPlant, $isCmo = false)
    {
        $configEnv = \configEmailNotification();
        $acp   = AcpTable::find($quotation_id);
        $plantHead ='';
        
        if( $acp->plant_id == '1101' OR $acp->plant_id == '2101' ) {
            $plantHead = '120049';
        } else if( $acp->plant_id == '1201') {
            $plantHead = '020300';
        } else if( $acp->plant_id == '1202' ) {
            $plantHead = '130639';
        }

        if( $tingkat == 'STAFF' ) {
            if( $isPlant ) {
                QuotationApproval::create([
                    'nik'                   => $plantHead,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
               
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));

                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
    
                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 3,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            } else {
                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));
    
                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            }
            
        } else if ($tingkat == 'CFO') {
            if( $isPlant ) {
                QuotationApproval::create([
                    'nik'                   => $plantHead,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));

                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

    
                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 3,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
                
                $nexturutan = 4;
                if( $isCmo ) {
                    $nexturutan = 5;
                    QuotationApproval::create([
                        'nik'                   => 190026,
                        'approval_position'     => 4,
                        'status'                => QuotationApproval::waitingApproval,
                        'quotation_id'          => $quotation_id,
                        'flag'                  => 0,
                        'acp_type'              => $type,
                        'acp_id'                => $quotation_id
                    ]);
                }
                
                QuotationApproval::create([
                    'nik'                   => 180095,
                    'approval_position'     => $nexturutan,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            } else {
                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
                    
                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));

                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                $nexturutan = 3;
                if( $isCmo ) {
                    $nexturutan = 4;
                    QuotationApproval::create([
                        'nik'                   => 190026,
                        'approval_position'     => 3,
                        'status'                => QuotationApproval::waitingApproval,
                        'quotation_id'          => $quotation_id,
                        'flag'                  => 0,
                        'acp_type'              => $type,
                        'acp_id'                => $quotation_id
                    ]);
                }
                
                QuotationApproval::create([
                    'nik'                   => 180095,
                    'approval_position'     => $nexturutan,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            }
        } else if ($tingkat == 'COO') {
            if( $isPlant ) {
                QuotationApproval::create([
                    'nik'                   => $plantHead,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));

                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
    
                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 3,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                $nexturutan = 4;
                if( $isCmo ) {
                    $nexturutan = 5;
                    QuotationApproval::create([
                        'nik'                   => 190026,
                        'approval_position'     => 4,
                        'status'                => QuotationApproval::waitingApproval,
                        'quotation_id'          => $quotation_id,
                        'flag'                  => 0,
                        'acp_type'              => $type,
                        'acp_id'                => $quotation_id
                    ]);
                }
                
                QuotationApproval::create([
                    'nik'                   => 180095,
                    'approval_position'     => $nexturutan,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
                QuotationApproval::create([
                    'nik'                   => 180178,
                    'approval_position'     => 5,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            } else {
                QuotationApproval::create([
                    'nik'                   => $assProc,
                    'approval_position'     => 1,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 1,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                if (\App\Models\BaseModel::Development == $configEnv->type) {
                    $email = "diditriawan13@gmail.com";
                    $name  = "didi";
                } else {
                    $email = \Auth::user()->email;
                    $name  = \Auth::user()->name;
                }
                \Mail::to($email)->send(new enesisApprovalAcpMail($acp, $name));
    
                QuotationApproval::create([
                    'nik'                   => 'PROCUREMENT01',
                    'approval_position'     => 2,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);

                $nexturutan = 3;
                if( $isCmo ) {
                    $nexturutan = 4;
                    QuotationApproval::create([
                        'nik'                   => 190026,
                        'approval_position'     => 3,
                        'status'                => QuotationApproval::waitingApproval,
                        'quotation_id'          => $quotation_id,
                        'flag'                  => 0,
                        'acp_type'              => $type,
                        'acp_id'                => $quotation_id
                    ]);
                }
                
                QuotationApproval::create([
                    'nik'                   => 180095,
                    'approval_position'     => $nexturutan,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
                QuotationApproval::create([
                    'nik'                   => 180178,
                    'approval_position'     => 4,
                    'status'                => QuotationApproval::waitingApproval,
                    'quotation_id'          => $quotation_id,
                    'flag'                  => 0,
                    'acp_type'              => $type,
                    'acp_id'                => $quotation_id
                ]);
            }
        }
    }

    function removeTitik($titik)
    {
        return str_replace('.','',$titik);
    }

    function removeComma($comma)
    {
        return str_replace(',','',$comma);
    }

    function toDecimal($duit)
    {
        return number_format($duit, 2, ".", ",");
    }

    function date_compare($a, $b)
    {
        $t1 = strtotime($a['Date']);
        $t2 = strtotime($b['Date']);
        return $t2 - $t1;  // descending
    }  

    function compareByTimeStamp($time1, $time2) 
    { 
        if (strtotime($time1) < strtotime($time2)) 
            return 1; 
        else if (strtotime($time1) > strtotime($time2))  
            return -1; 
        else
            return 0; 
    } 
?>