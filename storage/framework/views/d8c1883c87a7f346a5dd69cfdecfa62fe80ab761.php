<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="<?php echo e(route("admin.home")); ?>" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    <?php echo e(trans('global.dashboard')); ?>

                </a>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('master_document_access')): ?>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-file nav-icon">

                        </i>
                        <?php echo e(trans('cruds.master-document.title')); ?>

                    </a>
                    <ul class="nav-dropdown-items">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.document.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/document') || request()->is('admin/document/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-file nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.document.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_category_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.document-category.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/document-category') || request()->is('admin/document-category/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-circle nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.document-category.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_management_access')): ?>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-barcode nav-icon">

                        </i>
                        <?php echo e(trans('cruds.work-order.title')); ?>

                    </a>
                    <ul class="nav-dropdown-items">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.work-order.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/work-order/') || request()->is('admin/work-order/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-list nav-icon">
                                    </i>
                                    <?php echo e(trans('cruds.work-order.fields.list_wo')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_all_module_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.work-order-all-hierarchy")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/work-order-all-hierarchy') || request()->is('admin/work-order-all-hierarchy/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-book nav-icon">
                                    </i>
                                    <?php echo e(trans('cruds.work-order.fields.all_module')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.work-order-module.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/work-order-module') || request()->is('admin/work-order-module/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-book nav-icon">
                                    </i>
                                    <?php echo e(trans('cruds.work-order.fields.module')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        <?php echo e(trans('cruds.userManagement.title')); ?>

                    </a>
                    <ul class="nav-dropdown-items">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.permissions.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.permission.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.roles.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.role.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route("admin.users.index")); ?>"
                                   class="nav-link <?php echo e(request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : ''); ?>">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    <?php echo e(trans('cruds.user.title')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="#" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    <?php echo e(trans('global.logout')); ?>

                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/partials/menu.blade.php ENDPATH**/ ?>