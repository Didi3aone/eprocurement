<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>
                
                <li><a href="<?php echo e(route('admin.home')); ?>">Dashboard</a></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('request_notes_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-clipboard"></i>
                        <span class="hide-menu"> <?php echo e('Request Note'); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('request_notes_access')): ?>
                        <li>
                            <a href="<?php echo e(route('admin.request-note')); ?>" class="">
                                <i class="fa fas fa-caret-right"></i> 
                                List Rn
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_request_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-file"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.purchase_request.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_request_access')): ?>
                        <li>
                            <li>
                                <a href="<?php echo e(route('admin.purchase-request.index')); ?>" class="">
                                    <i class="fa fas fa-caret-right"></i> 
                                    List PR
                                </a>
                            </li>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_request_approval_access')): ?>
                        <li>
                            <li>
                                <a href="<?php echo e(route('admin.purchase-request-list-approval')); ?>" class="">
                                    <i class="fa fas fa-caret-right"></i> 
                                    Approval PR
                                </a>
                            </li>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_request_validate_access')): ?>
                        <li>
                            <li>
                                <a href="<?php echo e(route('admin.purchase-request-list-validate')); ?>" class="">
                                    <i class="fa fas fa-caret-right"></i> 
                                    Validate Assets PR
                                </a>
                            </li>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_order_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-truck"></i>
                        <span class="hide-menu"> <?php echo e('Purchase Order'); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            
                            <li>
                                <a href="#" class="">
                                    <i class="fa fas fa-caret-right"></i> 
                                    List PR
                                </a>
                            </li>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('master_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.masterManagement.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-cubes">
                                </i> <?php echo e(trans('cruds.masterMaterial.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.material.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.masterMaterial.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchasing_group_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.purchasing_group.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.purchasing_group.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material_group_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.material_group.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.material_group.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material_type_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.material_type.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.material_type.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('plant_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.plant.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.plant.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profit_center_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.profit_center.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.profit_center.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gl_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-file">
                                </i> <?php echo e(trans('cruds.gl.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gl_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.gl.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.gl.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-file-o">
                                </i> <?php echo e(trans('cruds.cost.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.cost.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.cost.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
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