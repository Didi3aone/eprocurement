<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Management</a></li>
            <li class="breadcrumb-item">Permission</li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form-material m-t-40" action="<?php echo e(route("admin.permissions.store")); ?>" enctype="multipart/form-data" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.permission.fields.title')); ?></label>
                        <input type="text" class="form-control form-control-line <?php echo e($errors->has('title') ? 'is-invalid' : ''); ?>" name="title" value="<?php echo e(old('title', '')); ?>"> 
                        <?php if($errors->has('title')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('title')); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/permissions/create.blade.php ENDPATH**/ ?>