<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item">Category</li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="<?php echo e(route("admin.department-category.update", $category->id)); ?>" enctype="multipart/form-data" method="post">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterCategoryDept.fields.code')); ?></label>
                        <input type="text" class="form-control form-control-line <?php echo e($errors->has('code') ? 'is-invalid' : ''); ?>" name="code" value="<?php echo e($category->code ?? old('code', '')); ?>"> 
                        <?php if($errors->has('code')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('code')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.masterCategoryDept.fields.name')); ?></label>
                        <input type="text" class="form-control form-control-line <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" name="name" value="<?php echo e($category->name ?? old('name', '')); ?>"> 
                        <?php if($errors->has('name')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('name')); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/department/category/edit.blade.php ENDPATH**/ ?>