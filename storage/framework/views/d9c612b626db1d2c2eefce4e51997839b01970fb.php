<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('work_order_module_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route("admin.work-order.create")); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.work-order.title_singular')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('cruds.work-order.title_singular')); ?> <?php echo e(trans('global.list')); ?>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.wo_no')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.by')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.department')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.work-order.fields.module')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.sub_module')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('global.title')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.assigned_to')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.priority')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('global.status')); ?>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $workOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($workOrders->id); ?>">
                            <td>
                                <?php echo e(++$i); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.work-order.index').'/'.$workOrders->id); ?>">
                                    <?php echo e($workOrders->work_order_no ?? ''); ?>

                                </a>
                            </td>
                            <td>
                                <?php echo e($workOrders->getCreatedByUser['name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->getWorkOrderModule['getDataDepartment']['name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->getWorkOrderModule['name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->getWorkOrderSubModule['name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->title ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->getWorkOrderSubModule['getPicName']['display_name'] ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->priority ?? ''); ?>

                            </td>
                            <td>
                                <?php echo e($workOrders->status ?? ''); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/list-wo/index.blade.php ENDPATH**/ ?>