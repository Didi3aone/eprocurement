<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                
                <li><a href="<?php echo e(route('admin.home')); ?>">Dashboard</a></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('master_access')): ?>
                    <li class=""> 
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                            <span class="hide-menu"> <?php echo e(trans('cruds.masterManagement.title')); ?> </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                                <li>
                                    <a href="#" class="has-arrow "> 
                                        <i class="fa fa-users">

                                        </i> <span class="hide-menu"> <?php echo e(trans('cruds.userManagement.title')); ?></span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                                                <a href="<?php echo e(route("admin.users.index")); ?>" class="<?php echo e(request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : ''); ?>">
                                                    <i class="fa fa-user"></i> <?php echo e(trans('cruds.user.title')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                                                <a href="<?php echo e(route("admin.roles.index")); ?>" class="<?php echo e(request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : ''); ?>">
                                                    <i class="fa fa-briefcase"></i> <?php echo e(trans('cruds.role.title')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                                                <a href="<?php echo e(route("admin.permissions.index")); ?>" class="<?php echo e(request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : ''); ?>">
                                                    <i class="fa fa-unlock-alt"></i> <?php echo e(trans('cruds.permission.title')); ?>

                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_management_access')): ?>
                                <li>
                                    <a href="#" class="has-arrow">
                                        <i class="fa fa-building">

                                        </i> <?php echo e(trans('cruds.masterDepartment.title')); ?>

                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_access')): ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.department.index')); ?>" class="">
                                                    <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.masterDepartment.title')); ?>

                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_category_access')): ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.department-category.index')); ?>" class="">
                                                    <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.masterCategoryDept.title')); ?>

                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power"></i>
        </a>

        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    <!-- End Bottom points-->
</aside><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/partials/menu.blade.php ENDPATH**/ ?>