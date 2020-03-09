<?php $__env->startSection('content'); ?>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Department</a></li>
            <li class="breadcrumb-item active">List</li>
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
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success float-rigth" href="<?php echo e(route("admin.department.create")); ?>">
                <i class="fa fa-plus"></i> <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.masterDepartment.title_singular')); ?>

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
                                <?php echo e(trans('cruds.masterDepartment.fields.id')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('cruds.masterDepartment.fields.category_id')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('cruds.masterDepartment.fields.name')); ?>

                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-entry-id="<?php echo e($val->id); ?>">
                                    <td>

                                    </td>
                                    <td>
                                        <?php echo e($val->code ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($val['category']->name ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($val->name ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_show')): ?>
                                            <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.department.show', $val->id)); ?>">
                                                <?php echo e(trans('global.view')); ?>

                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_edit')): ?>
                                            <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.department.edit', $val->id)); ?>">
                                                <?php echo e(trans('global.edit')); ?>

                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('department_delete')): ?>
                                            <form action="<?php echo e(route('admin.permissions.destroy', $val->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete')); ?>">
                                            </form>
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/eprocurement/resources/views/admin/department/index.blade.php ENDPATH**/ ?>