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
                        @can('vendor_management_access')
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
                        @endcan
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
                        @can('bidding_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> {{ trans('cruds.inputBidding.title') }}
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                @can('bidding_access')
                                <li>
                                    <a href="{{ route('admin.bidding.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.inputBidding.title') }}
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