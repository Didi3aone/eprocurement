<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User Management</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php echo e(route("admin.users.update", [$user->id])); ?>" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.user.fields.name')); ?></label>
                        <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name" id="name" value="<?php echo e($user->name ?? old('name', '')); ?>" required>
                        <?php if($errors->has('name')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('name')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="required" for="email"><?php echo e(trans('cruds.user.fields.email')); ?></label>
                        <input class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" type="text" name="email" id="email" value="<?php echo e($user->email ?? old('email')); ?>" required>
                        <?php if($errors->has('email')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('email')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.email_helper')); ?></span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="password"><?php echo e(trans('cruds.user.fields.password')); ?></label>
                        <input class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" type="password" name="password" id="password" required>
                        <?php if($errors->has('password')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('password')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.password_helper')); ?></span>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.user.fields.roles')); ?></label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all')); ?></span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all')); ?></span>
                        </div>
                        <select class="form-control select2 <?php echo e($errors->has('roles') ? 'is-invalid' : ''); ?>" name="roles[]" id="roles" multiple required>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e((in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : ''); ?>><?php echo e($roles); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('roles')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('roles')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo e(trans('cruds.user.fields.department_id')); ?></label>
                        <select class="form-control select2 <?php echo e($errors->has('roles') ? 'is-invalid' : ''); ?>" name="department_id" id="department_id" required>
                            <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e($user->department_id == $id ? "selected" : in_array($id, old('department_id', [])) ? 'selected' : ''); ?>><?php echo e($dept); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('roles')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('roles')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> <?php echo e(trans('global.save')); ?></button>
                        <a href="<?php echo e(route('admin.users.index')); ?>" type="button" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>