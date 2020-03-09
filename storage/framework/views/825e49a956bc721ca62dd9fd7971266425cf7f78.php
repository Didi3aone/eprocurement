<?php $__env->startSection('content'); ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-default" href="<?php echo e(route("admin.work-order.index")); ?>">
                Back To List WO
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id).'?status=Approve'); ?>">
                Approve
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id).'?status=Re-Assign'); ?>">
                Re-Assign
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id).'?status=Reject'); ?>">
                Reject/Cancel
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id)); ?>">
                <?php echo e(trans('global.edit')); ?>

            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id).'?status=Complete'); ?>">
                Complete
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.edit", $workOrder->id).'?status=finish'); ?>">
                Finish
            </a>
            <a class="btn btn-success" href="<?php echo e(route("admin.work-order.create")); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.work-order.fields.notes')); ?>

            </a>
        </div>
    </div>
    <div class="card ">
        <div class="card-body">
            <div class="form-group">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            Order ID
                        </th>
                        <td>
                            <?php echo e($workOrder->work_order_no ?? ''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('global.date')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->created_at ?? ''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.by')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->getCreatedByUser['name'] ?? ''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.module')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->getWorkOrderModule['name'] ??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.sub_module')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->getWorkOrderSubModule['name'] ??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.detail')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->getWorkOrderDetail['name'] ??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.assigned_to')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->getWorkOrderSubModule->getPicName['display_name'] ??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('global.title')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->title ??''); ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('global.description')); ?>

                        </th>
                        <td>
                            <?php echo $workOrder->description ??''; ?>

                        </td>
                    </tr>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.priority')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->priority ??''); ?>

                        </td>
                    </tr>
                    <?php if($workOrder->date_promised): ?>
                        <tr>
                            <th>
                                Date Promised
                            </th>
                            <td>
                                <?php echo e(date('Y-m-d' ,strtotime($workOrder->date_promised)) ??''); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.status')); ?>

                        </th>
                        <td>
                            <?php echo e($workOrder->status ??''); ?>

                        </td>
                    </tr>
                    <?php if(isset($workOrder->notes)): ?>
                        <tr>
                            <th>
                                <?php echo e(trans('cruds.work-order.fields.notes')); ?>

                            </th>
                            <td>
                                <?php echo $workOrder->notes ??''; ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            History Logs Work Order
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th>
                            <?php echo e(trans('global.create')); ?> <?php echo e(trans('global.date')); ?>

                        </th>
                        <th>

                            <?php echo e(trans('cruds.work-order.fields.notes')); ?>

                        </th>
                        <th>
                            Responsible ID

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.status')); ?>

                        </th>
                        <th>
                            Process Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $workOrder->getWorkOrderHistoryLog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historyLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($historyLog->created_at ?? ''); ?></td>
                            <td><?php echo e($historyLog->notes ?? ''); ?></td>
                            <td><?php echo e($historyLog->getResponsibleId['display_name'] ?? ''); ?></td>
                            <td><?php echo e($historyLog->status ?? ''); ?></td>
                            <td><?php echo e($historyLog->process_date ?? ''); ?></td>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });

            $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons});

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/list-wo/show.blade.php ENDPATH**/ ?>