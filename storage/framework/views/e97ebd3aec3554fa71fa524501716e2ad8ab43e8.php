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
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('material_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
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
                                <i class="fa fa-truck">
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
                                <i class="fa fa-truck">
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
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.company.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.masterCompany.title')); ?>

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
                

                
                
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.masterTransaction.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rn_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.inputRN.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rn_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rn.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.inputRN.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pr_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.inputPR.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pr_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.pr.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.inputPR.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.inputPO.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.po.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.inputPO.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approval_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.approval.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approval_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.approval.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.approval.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                
                

                
                
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.masterReport.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rstatus_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.reportStatus.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rstatus_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rstatus.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.reportStatus.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rgr_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.reportGR.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rgr_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rgr.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.reportGR.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rvendor_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.reportVendor.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rvendor_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rvendor.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.reportVendor.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rmaterial_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.reportMaterial.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rmaterial_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rmaterial.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.reportMaterial.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rstock_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.reportStock.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rstock_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.rstock.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.reportStock.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vendor_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.vendors.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vendor_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.vendors.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vendor_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.vendors.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.vendors.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bidding_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.bidding.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bidding_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.bidding.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bidding_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.bidding.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.bidding.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faktur_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.faktur.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faktur_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.faktur.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faktur_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.faktur.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.faktur.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approvalRN_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.approvalRN.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approvalRN_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.approvalRN.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approvalRN_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.approvalRN.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.approvalRN.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listRN_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.listRN.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listRN_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.listRN.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listRN_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.listRN.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.listRN.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procListRN2PR_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procListRN2PR.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procListRN2PR_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procListRN2PR.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procListRN2PR_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procListRN2PR.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procListRN2PR.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procApprovalRN2PR_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procApprovalRN2PR.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procApprovalRN2PR_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procApprovalRN2PR.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procApprovalRN2PR_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procApprovalRN2PR.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procApprovalRN2PR.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procValidasiAset_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procValidasiAset.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procValidasiAset_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procValidasiAset.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procValidasiAset_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procValidasiAset.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procValidasiAset.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procPR2PO_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procPR2PO.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procPR2PO_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procPR2PO.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procPR2PO_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procPR2PO.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procPR2PO.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procBidding_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procBidding.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procBidding_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procBidding.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procBidding_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procBidding.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procBidding.title')); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procVerifikasiFaktur_access')): ?>
                <li class=""> 
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-list"></i>
                        <span class="hide-menu"> <?php echo e(trans('cruds.procVerifikasiFaktur.title')); ?> </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procVerifikasiFaktur_management_access')): ?>
                        <li>
                            <a href="#" class="has-arrow">
                                <i class="fa fa-truck">
                                </i> <?php echo e(trans('cruds.procVerifikasiFaktur.title')); ?>

                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('procVerifikasiFaktur_access')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.procVerifikasiFaktur.index')); ?>" class="">
                                        <i class="fa fas fa-caret-right"></i> <?php echo e(trans('cruds.procVerifikasiFaktur.title')); ?>

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