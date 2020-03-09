<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(trans('panel.site_title')); ?></title>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/coreui.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/font-awesome.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/all.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/dropzone.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    <div class="app flex-row align-items-center">
        <div class="container">
            <?php echo $__env->yieldContent("content"); ?>
        </div>
    </div>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/layouts/app.blade.php ENDPATH**/ ?>