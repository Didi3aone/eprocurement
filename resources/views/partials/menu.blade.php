<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                {{-- <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                    <ul aria-expanded="false" class="collapse">
                    </ul>
                </li> --}}
                <li><a href="{{ route('admin.home') }}">Dashboard</a></li>

                {{-- start master menu --}}
                @can('master_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.masterManagement.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        {{-- @can('vendor_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.masterVendor.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('vendor_access')
                                <li>
                                    <a href="{{ route('admin.vendors.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.masterVendor.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan --}}
                        @can('material_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.masterMaterial.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('material_access')
                                <li>
                                    <a href="{{ route('admin.material.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.masterMaterial.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('purchasing_group_access')
                                <li>
                                    <a href="{{ route('admin.purchasing_group.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.purchasing_group.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('material_group_access')
                                <li>
                                    <a href="{{ route('admin.material_group.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.material_group.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('material_type_access')
                                <li>
                                    <a href="{{ route('admin.material_type.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.material_type.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('plant_access')
                                <li>
                                    <a href="{{ route('admin.plant.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.plant.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('profit_center_access')
                                <li>
                                    <a href="{{ route('admin.profit_center.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.profit_center.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('gl_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.gl.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('gl_access')
                                <li>
                                    <a href="{{ route('admin.gl.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.gl.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('cost_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.cost.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('cost_access')
                                <li>
                                    <a href="{{ route('admin.cost.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.cost.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('department_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-building">

                                </i> {{ trans('cruds.masterDepartment.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('department_access')
                                <li>
                                    <a href="{{ route('admin.department.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.masterDepartment.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('department_category_access')
                                <li>
                                    <a href="{{ route('admin.department-category.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.masterCategoryDept.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('company_access')
                                <li>
                                    <a href="{{ route('admin.company.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.masterCompany.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('user_management_access')
                        <li>
                            <a href="#" class="has-arrow "> 
                                <i class="fa fa-users">

                                </i> <span class="hide-menu"> {{ trans('cruds.userManagement.title') }}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    @can('user_access')
                                    <a href="{{ route("admin.users.index") }}" class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa fa-user"></i> {{ trans('cruds.user.title') }}
                                    </a>
                                    @endcan
                                    @can('role_access')
                                    <a href="{{ route("admin.roles.index") }}" class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa fa-briefcase"></i> {{ trans('cruds.role.title') }}
                                    </a>
                                    @endcan
                                    @can('permission_access')
                                    <a href="{{ route("admin.permissions.index") }}" class="{{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa fa-unlock-alt"></i> {{ trans('cruds.permission.title') }}
                                    </a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end master menu --}}

                {{-- start transaction menu --}}
                {{-- @can('transaction_access') --}}
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.masterTransaction.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('rn_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.inputRN.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rn_access')
                                <li>
                                    <a href="{{ route('admin.rn.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.inputRN.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('pr_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.inputPR.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('pr_access')
                                <li>
                                    <a href="{{ route('admin.pr.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.inputPR.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('po_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.inputPO.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('po_access')
                                <li>
                                    <a href="{{ route('admin.po.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.inputPO.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('approval_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.approval.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('approval_access')
                                <li>
                                    <a href="{{ route('admin.approval.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.approval.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                {{-- @endcan --}}
                {{-- end transaction menu --}}

                {{-- start report menu --}}
                {{-- @can('report_access') --}}
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.masterReport.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('rstatus_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.reportStatus.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rstatus_access')
                                <li>
                                    <a href="{{ route('admin.rstatus.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.reportStatus.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('rgr_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.reportGR.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rgr_access')
                                <li>
                                    <a href="{{ route('admin.rgr.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.reportGR.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('rvendor_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.reportVendor.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rvendor_access')
                                <li>
                                    <a href="{{ route('admin.rvendor.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.reportVendor.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('rmaterial_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.reportMaterial.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rmaterial_access')
                                <li>
                                    <a href="{{ route('admin.rmaterial.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.reportMaterial.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        @can('rstock_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.reportStock.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('rstock_access')
                                <li>
                                    <a href="{{ route('admin.rstock.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.reportStock.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                {{-- @endcan --}}
                {{-- end report menu --}}

                {{-- start vendor menu --}}
                @can('vendor_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.vendors.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('vendor_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.vendors.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('vendor_access')
                                <li>
                                    <a href="{{ route('admin.vendors.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.vendors.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end vendor menu --}}

                {{-- start bidding menu --}}
                @can('bidding_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.bidding.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('bidding_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.bidding.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('bidding_access')
                                <li>
                                    <a href="{{ route('admin.bidding.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.bidding.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end bidding menu --}}

                {{-- start bidding menu --}}
                @can('faktur_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.faktur.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('faktur_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.faktur.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('faktur_access')
                                <li>
                                    <a href="{{ route('admin.faktur.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.faktur.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end faktur menu --}}

                {{-- start approvalRN menu --}}
                @can('approvalRN_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.approvalRN.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('approvalRN_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.approvalRN.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('approvalRN_access')
                                <li>
                                    <a href="{{ route('admin.approvalRN.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.approvalRN.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end approvalRN menu --}}

                {{-- start listRN menu --}}
                @can('listRN_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.listRN.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('listRN_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.listRN.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('listRN_access')
                                <li>
                                    <a href="{{ route('admin.listRN.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.listRN.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end listRN menu --}}

                {{-- start procListRN2PR menu --}}
                @can('procListRN2PR_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procListRN2PR.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procListRN2PR_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procListRN2PR.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procListRN2PR_access')
                                <li>
                                    <a href="{{ route('admin.procListRN2PR.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procListRN2PR.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procListRN2PR menu --}}

                {{-- start procApprovalRN2PR menu --}}
                @can('procApprovalRN2PR_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procApprovalRN2PR.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procApprovalRN2PR_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procApprovalRN2PR.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procApprovalRN2PR_access')
                                <li>
                                    <a href="{{ route('admin.procApprovalRN2PR.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procApprovalRN2PR.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procApprovalRN2PR menu --}}

                {{-- start procValidasiAset menu --}}
                @can('procValidasiAset_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procValidasiAset.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procValidasiAset_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procValidasiAset.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procValidasiAset_access')
                                <li>
                                    <a href="{{ route('admin.procValidasiAset.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procValidasiAset.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procValidasiAset menu --}}

                {{-- start procPR2PO menu --}}
                @can('procPR2PO_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procPR2PO.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procPR2PO_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procPR2PO.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procPR2PO_access')
                                <li>
                                    <a href="{{ route('admin.procPR2PO.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procPR2PO.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procPR2PO menu --}}

                {{-- start procBidding menu --}}
                @can('procBidding_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procBidding.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procBidding_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procBidding.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procBidding_access')
                                <li>
                                    <a href="{{ route('admin.procBidding.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procBidding.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procBidding menu --}}

                {{-- start procVerifikasiFaktur menu --}}
                @can('procVerifikasiFaktur_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.procVerifikasiFaktur.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('procVerifikasiFaktur_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.procVerifikasiFaktur.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('procVerifikasiFaktur_access')
                                <li>
                                    <a href="{{ route('admin.procVerifikasiFaktur.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.procVerifikasiFaktur.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                {{-- end procVerifikasiFaktur menu --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    <!-- End Bottom points-->
</aside>