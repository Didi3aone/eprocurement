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
               
                @can('purchase_request_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file"></i>
                        <span class="hide-menu"> {{ trans('cruds.purchase_request.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                    
                        @can('purchase_request_access')
                        <li>
                            <a href="{{ route('admin.purchase-request.index') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List PR
                            </a>
                        </li>
                        @endcan
                        
                    </ul>
                </li>
                @endcan
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file"></i>
                        <span class="hide-menu"> {{ trans('cruds.quotation.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('purchase_request_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-cubes"></i> 
                                List Bidding
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="{{ route('admin.quotation.online') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> 
                                        Online
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.quotation.repeat') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> 
                                        PO Repeat
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.quotation.direct') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> 
                                        Direct Order
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('admin.quotation.list-winner') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List ACP
                            </a>
                        </li>
                        @endcan                        
                    </ul>
                </li>
                @can('purchase_order_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-truck"></i>
                        <span class="hide-menu"> {{ 'Purchase Order' }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('admin.purchase-order.index') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List PO
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.purchase-order.direct') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                Direct PO
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.purchase-order.release') }}" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                Release Strategy
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                {{-- start master menu --}}
                @can('master_access')
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> {{ trans('cruds.masterManagement.title') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @can('material_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-cubes">
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
                                @can('storage_location_access')
                                <li>
                                    <a href="{{ route('admin.storage-location.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.storage-location.title') }}
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
                                @can('asset_access')
                                <li>
                                    <a href="{{ route('admin.asset.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.asset.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('unit_access')
                                <li>
                                    <a href="{{ route('admin.unit.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.unit.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('account_assignment_access')
                                <li>
                                    <a href="{{ route('admin.account_assignment.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.account_assignment.title') }}
                                    </a>
                                </li>
                                @endcan
                                @can('material_category_access')
                                <li>
                                    <a href="{{ route('admin.material-category.index') }}" class="">
                                        <i class="fa fas fa-caret-right"></i> {{ trans('cruds.material-category.title') }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
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
                        @can('gl_management_access')
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-file">
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
                                <i class="fa fa-file-o">
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