<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.work-order.fields.sub_module')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(url("admin/work-order-module/$workOrderModules->id/sub-module/")); ?>"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" value="<?php echo e($workOrderModules->id); ?>" name="parentId">
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('cruds.work-order.fields.module')); ?></label>
                    <input class="form-control" type="text" value="<?php echo e($workOrderModules->name); ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('cruds.work-order.fields.sub_module')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name"
                           id="name" value="<?php echo e(old('name', '')); ?>" required>
                    <?php if($errors->has('name')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('name')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.detail_helper')); ?></span>
                </div>

                <div class="form-group">
                    <label class="" for="status"><?php echo e(trans('cruds.work-order.fields.status')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                   name="status" checked>
                            <label class="form-check-label" for="inline-radio-active">Active</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="0"
                                   name="status">
                            <label class="form-check-label" for="inline-radio-non-active">Non Active</label>
                        </div>
                    </div>
                    <?php if($errors->has('status')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('status')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.status_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.pic')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('pic') ? 'is-invalid' : ''); ?>"
                            name="pic" id="pic" required>
                        <option value="">-- Please Select --</option>
                        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"> <?php echo e($users); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('pic')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('pic')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.assigned_to_helper')); ?></span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                    <a class="btn btn-default" href="<?php echo e(url("admin/work-order-module/$workOrderModules->id")); ?>">
                        <?php echo e(trans('global.back_to_list')); ?>

                    </a>
                </div>
            </form>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/module/sub-module/create.blade.php ENDPATH**/ ?>