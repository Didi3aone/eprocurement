<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card mx-4">
            <div class="card-body p-4">

                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <h1><?php echo e(trans('panel.site_title')); ?></h1>
                    <p class="text-muted"><?php echo e(trans('global.register')); ?></p>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="name" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" required autofocus placeholder="<?php echo e(trans('global.user_name')); ?>" value="<?php echo e(old('name', null)); ?>">
                        <?php if($errors->has('name')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('name')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope fa-fw"></i>
                            </span>
                        </div>
                        <input type="email" name="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" required placeholder="<?php echo e(trans('global.login_email')); ?>" value="<?php echo e(old('email', null)); ?>">
                        <?php if($errors->has('email')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('email')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" required placeholder="<?php echo e(trans('global.login_password')); ?>">
                        <?php if($errors->has('password')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('password')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="<?php echo e(trans('global.login_password_confirmation')); ?>">
                    </div>

                    <button class="btn btn-block btn-primary">
                        <?php echo e(trans('global.register')); ?>

                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/auth/register.blade.php ENDPATH**/ ?>