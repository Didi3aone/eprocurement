<?php $__env->startSection('content'); ?>
<section id="wrapper">
    <div class="login-register" style="background-image:url(<?php echo e(asset('images/background/login-register.jpg')); ?>;">        
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" method="POST" id="loginform" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    
                        <center><img src="<?php echo e(asset('images/ene-group.jpg')); ?>" width=200></center>
                    
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control <?php echo e($errors->has('nik') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('nik', null)); ?>" name="nik" type="text" required="" placeholder="NIK"> 
                        </div>
                        <?php if($errors->has('nik')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('nik')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" type="password" name="password" required="" placeholder="Password"> 
                            <?php if($errors->has('password')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('password')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/auth/login.blade.php ENDPATH**/ ?>