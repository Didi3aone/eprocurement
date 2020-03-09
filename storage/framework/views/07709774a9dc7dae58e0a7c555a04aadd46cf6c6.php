<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.edit')); ?> <?php echo e(trans('cruds.document-category.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("admin.document-category.update",$DocumentCategory->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('cruds.document-category.fields.name')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name" id="name" value="<?php echo e($DocumentCategory->name ?? old('name', '')); ?>" required>
                    <?php if($errors->has('name')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('name')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document-category.fields.name_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="code"><?php echo e(trans('cruds.document-category.fields.code')); ?></label>
                    <input class="form-control <?php echo e($errors->has('code') ? 'is-invalid' : ''); ?>" type="text" name="code" id="code" value="<?php echo e($DocumentCategory->code ?? old('code', '')); ?>" required>
                    <?php if($errors->has('code')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('code')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document-category.fields.code_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.document-category.fields.departmentId')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('departmentId') ? 'is-invalid' : ''); ?>" name="departmentId" id="departmentId" required>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e($DocumentCategory->departmentId === $id ? 'selected' : in_array($id, old('departmentId', []))  ? 'selected' : ''); ?>><?php echo e($departments .' - '. $id); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('departmentId')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('departmentId')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document-category.fields.department_helper')); ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                    <a class="btn btn-default" href="<?php echo e(route('admin.document-category.index')); ?>">
                        <?php echo e(trans('global.back_to_list')); ?>

                    </a>
                </div>
            </form>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/master-document/category/edit.blade.php ENDPATH**/ ?>