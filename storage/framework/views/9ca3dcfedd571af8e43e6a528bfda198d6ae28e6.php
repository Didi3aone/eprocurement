<?php $__env->startSection('content'); ?>
    <div class="card ">
        <div class="card-body">
            <div class="form-group">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.module')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrderModules->name); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.sub_module')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrderModules->submodule[0]['name']); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.status')); ?>

                        </th>
                        <td>
                            <?php echo e(\App\Models\WorkOrderModule::Status_TYPE[$workOrderModules->submodule[0]['status']]); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.pic')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrderModules->submodule[0]['getPicName']->display_name ??''); ?>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success"
                   href="<?php echo e(url('admin/work-order-module/'.$workOrderModules->id.'/sub-module/'.$workOrderModules->submodule[0]['id'].'/detail/create')); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.work-order.fields.detail')); ?>

                </a>
                <a class="btn btn-default"
                   href="<?php echo e(url('admin/work-order-module/'.$workOrderModules->id.'/sub-module/')); ?>">
                    Back To Sub Module
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('cruds.work-order.fields.detail')); ?> <?php echo e(trans('global.list')); ?>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.id')); ?>

                        </th>
                        <th>

                            <?php echo e(trans('cruds.work-order.fields.module')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.sub_module')); ?>


                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.detail')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.status')); ?>

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>

                    <?php $__currentLoopData = $workOrderModules->submodule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrderModuling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $workOrderModuling->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrderModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-entry-id="<?php echo e($workOrderModule->id); ?>">
                                <td>
                                    <?php echo e(++$i); ?>

                                </td>
                                <td>
                                    <a href="<?php echo e(url('admin/work-order-module/'.$workOrderModuling->id)); ?>">
                                        <?php echo e($workOrderModules->name ?? ''); ?>

                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo e(url('admin/work-order-module/'.$workOrderModuling->id.'/sub-module/'.$workOrderModule->id.'/detail/')); ?>">
                                        <?php echo e($workOrderModuling->name ?? ''); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php echo e($workOrderModule->name ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e(\App\Models\WorkOrderModule::Status_TYPE[$workOrderModule->status] ?? ''); ?>

                                </td>

                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_show')): ?>
                                        <a class="btn btn-xs btn-primary"
                                           href="<?php echo e(url('admin/work-order-module/'.$workOrderModules->id.'/sub-module/'.$workOrderModuling->id.'/detail/'.$workOrderModule->id.'/show')); ?>">
                                            <?php echo e(trans('global.view')); ?>

                                        </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_edit')): ?>
                                        <a class="btn btn-xs btn-info"
                                           href="<?php echo e(url('admin/work-order-module/'.$workOrderModules->id.'/sub-module/'.$workOrderModuling->id.'/detail/'.$workOrderModule->id.'/edit')); ?>">
                                            <?php echo e(trans('global.edit')); ?>

                                        </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_delete')): ?>
                                        <form
                                            action="<?php echo e(url('admin/work-order-module/'.$workOrderModules->id.'/sub-module/'.$workOrderModuling->id.'/detail/'.$workOrderModule->id)); ?>"
                                            method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                   value="<?php echo e(trans('global.delete')); ?>">
                                        </form>
                                    <?php endif; ?>

                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/module/detail/index.blade.php ENDPATH**/ ?>