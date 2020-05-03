<?php
    use Carbon\Carbon;

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
?>