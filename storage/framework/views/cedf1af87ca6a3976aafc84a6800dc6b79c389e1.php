<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            <?php echo e(session('status')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_category_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route("admin.document-category.create")); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.document-category.fields.category')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('cruds.document-category.title_singular')); ?> <?php echo e(trans('global.list')); ?>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('cruds.document-category.fields.id')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document-category.fields.code')); ?>

                        </th>
                        
                        <th>
                            <?php echo e(trans('cruds.document-category.fields.name')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document-category.fields.departmentId')); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $DataCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($rows->id); ?>">
                            <td>

                            </td>
                            <td>
                                <?php echo e(++$i); ?>

                            </td>
                            <td>
                                <?php echo e($rows->code); ?>

                            </td>
                            <td>
                                <?php echo e($rows->name); ?>

                            </td>
                            <td>
                                <?php echo e($rows->getDataDepartment['name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_category_edit')): ?>
                                    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.document-category.edit', $rows->id)); ?>">
                                        <?php echo e(trans('global.edit')); ?>

                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_category_delete')): ?>
                                    <form action="<?php echo e(route('admin.document-category.destroy', $rows->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');" style="display: inline-block;">
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <script>
        
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/master-document/category/index.blade.php ENDPATH**/ ?>