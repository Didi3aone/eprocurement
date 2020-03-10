<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item active">Category</li>
        </ol>
    </div>
</div>
<?php if(session('status')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <?php echo e(session('status')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_category_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success float-rigth" href="<?php echo e(route("admin.department-category.create")); ?>">
                <i class="fa fa-plus"></i> <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.masterCategoryDept.title_singular')); ?>

            </a>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="datatables-run" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                <?php echo e(trans('cruds.masterCategoryDept.fields.id')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('cruds.masterCategoryDept.fields.code')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('cruds.masterCategoryDept.fields.name')); ?>

                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-entry-id="<?php echo e($val->id); ?>">
                                    <td>

                                    </td>
                                    <td>
                                        <?php echo e($val->id ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($val->code ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($val->name ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_category_show')): ?>
                                            <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.department-category.show', $val->id)); ?>">
                                                <?php echo e(trans('global.view')); ?>

                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_category_edit')): ?>
                                            <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.department-category.edit', $val->id)); ?>">
                                                <?php echo e(trans('global.edit')); ?>

                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_category_delete')): ?>
                                            
                                            <button class="btn btn-xs btn-danger" onclick="deleteConfirmation(<?php echo e($val->id); ?>)">Delete</button>
                                        <?php endif; ?>

                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
    $('#datatables-run').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    function deleteConfirmation(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(url('admin.department-category.destroy')); ?>"+id ,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            swal("Done!", results.message, "success");
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/department/category/index.blade.php ENDPATH**/ ?>