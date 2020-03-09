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
                @can('master_access')
                    <li class=""> 
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                            <span class="hide-menu"> {{ trans('cruds.masterManagement.title') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
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
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
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