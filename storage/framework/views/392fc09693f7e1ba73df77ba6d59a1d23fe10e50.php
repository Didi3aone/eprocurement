<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.work-order.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("admin.work-order-module.store")); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('cruds.work-order.fields.module')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name"
                           id="name" value="<?php echo e(old('name', '')); ?>" required>
                    <?php if($errors->has('name')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('name')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.department')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('departmentId') ? 'is-invalid' : ''); ?>"
                            name="departmentId" id="departmentId" required>
                        <option value="">-- Select Department --</option>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($id); ?>" <?php echo e(in_array($id, old('departmentId', [])) ? 'selected' : ''); ?>><?php echo e($departments .' - '. $id); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('departmentId')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('departmentId')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.department_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="status"><?php echo e(trans('cruds.work-order.fields.status')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="0"
                                   name="status">
                            <label class="form-check-label" for="inline-radio-active">Active</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="1"
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
                    <button class="btn btn-danger" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                    <a class="btn btn-default" href="<?php echo e(route('admin.work-order-module.index')); ?>">
                        <?php echo e(trans('global.back_to_list')); ?>

                    </a>
                </div>
            </form>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/module/create.blade.php ENDPATH**/ ?>