<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(trans('panel.site_title')); ?></title>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/all.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/jquery.dataTables.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/buttons.dataTables.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/select.dataTables.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('css/coreui.min.css')); ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full"><?php echo e(trans('panel.site_title')); ?></span>
            <span class="navbar-brand-minimized"><?php echo e(trans('panel.site_title')); ?></span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="nav navbar-nav ml-auto">
            <?php if(count(config('panel.available_languages', [])) > 1): ?>
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo e(strtoupper(app()->getLocale())); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php $__currentLoopData = config('panel.available_languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langLocale => $langName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item" href="<?php echo e(url()->current()); ?>?change_language=<?php echo e($langLocale); ?>"><?php echo e(strtoupper($langLocale)); ?> (<?php echo e($langName); ?>)</a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </li>
            <?php endif; ?>


        </ul>
    </header>

    <div class="app-body">
        <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">
                <?php if(session('message')): ?>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert"><?php echo e(session('message')); ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($errors->count() > 0): ?>
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>

            </div>


        </main>
        <form id="logoutform" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

        </form>
    </div>
    <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/coreui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/buttons.colVis.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dropzone.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-tagsinput.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>

    <script>
        $(function() {
  let copyButtonTrans = '<?php echo e(trans('global.datatables.copy')); ?>'
  let csvButtonTrans = '<?php echo e(trans('global.datatables.csv')); ?>'
  let excelButtonTrans = '<?php echo e(trans('global.datatables.excel')); ?>'
  let pdfButtonTrans = '<?php echo e(trans('global.datatables.pdf')); ?>'
  let printButtonTrans = '<?php echo e(trans('global.datatables.print')); ?>'
  let colvisButtonTrans = '<?php echo e(trans('global.datatables.colvis')); ?>'

  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
        'id': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['<?php echo e(app()->getLocale()); ?>']
    },
    columnDefs: [{
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    scrollX: true,
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'copy',
        className: 'btn-default',
        text: copyButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default',
        text: excelButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      // {
      //   extend: 'pdf',
      //   className: 'btn-default',
      //   text: pdfButtonTrans,
      //   exportOptions: {
      //     columns: ':visible'
      //   }
      // },
      // {
      //   extend: 'print',
      //   className: 'btn-default',
      //   text: printButtonTrans,
      //   exportOptions: {
      //     columns: ':visible'
      //   }
      // },
      {
        extend: 'colvis',
        className: 'btn-default',
        text: colvisButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/layouts/admin.blade.php ENDPATH**/ ?>