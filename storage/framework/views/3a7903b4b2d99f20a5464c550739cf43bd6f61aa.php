<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Department</h4>
                <form class="form-material m-t-40" action="<?php echo e(route("admin.department.update", $department->id)); ?>" enctype="multipart/form-data" method="post">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterCategoryDept.fields.id')); ?></label>
                        <input type="text" class="form-control form-control-line <?php echo e($errors->has('code') ? 'is-invalid' : ''); ?>" name="code" value="<?php echo e($department->code ?? old('code', '')); ?>"> 
                        <?php if($errors->has('code')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('code')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterCategoryDept.fields.name')); ?></label>
                        <input type="text" class="form-control form-control-line <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" name="name" value="<?php echo e($department->name ??  old('name', '')); ?>"> 
                        <?php if($errors->has('name')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('name')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterDepartment.fields.company_id')); ?></label>
                        <select class="form-control select2 <?php echo e($errors->has('company_id') ? 'is-invalid' : ''); ?>" name="company_id" id="company_id" required>
                            <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cmp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cmp->id); ?>" <?php echo e($department->company_id ? "selected" : in_array($cmp->id, old('company_id', [])) ? 'selected' : ''); ?>><?php echo e($cmp->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('company_id')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('company_id')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterDepartment.fields.status')); ?></label>
                        <div class="">
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-active" type="radio" value="active"
                                    name="status" <?php if($department->status == "active" ): ?>  checked <?php endif; ?>>
                                <label class="form-check-label" for="inline-radio-active"><?php echo e(trans('cruds.masterDepartment.fields.status_active')); ?></label>
                            </div>
                            <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio-non-active" type="radio" value="inactive"
                                    name="status" <?php if($department->status == "inactive" ): ?>  checked <?php endif; ?>>
                                <label class="form-check-label" for="inline-radio-non-active"><?php echo e(trans('cruds.masterDepartment.fields.status_inactive')); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterDepartment.fields.category_id')); ?></label>
                        <select class="form-control select2 <?php echo e($errors->has('category_id') ? 'is-invalid' : ''); ?>" name="category_id" id="category_id" required>
                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e($department->category_id == $cat->id ? "selected" : in_array($cat->id, old('category_id', [])) ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('category_id')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('category_id')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo e(trans('global.save')); ?></button>
                        <button type="button" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/department/edit.blade.php ENDPATH**/ ?>