<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('cruds.work-order.title_singular')); ?>  <?php echo e(trans('cruds.work-order.fields.module')); ?> <?php echo e(trans('global.list')); ?>

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
                            <?php echo e(trans('cruds.work-order.fields.department')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.modul')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.sub_modul')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.detail')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.pic')); ?>

                        </th>
                        <th>
                            <?php echo e(trans('cruds.work-order.fields.status')); ?>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    <?php $__currentLoopData = $workOrderModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrderModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($workOrderModule->submodule) >  0): ?>
                            <?php $__currentLoopData = $workOrderModule->submodule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($submodule->detail) > 0): ?>
                                    <?php $__currentLoopData = $submodule->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-entry-id="<?php echo e($detail->id); ?>">
                                            <td>
                                                <?php echo e(++$i); ?>

                                            </td>
                                            <td>
                                                <?php echo e($workOrderModule->getDataDepartment['name'] ?? ''); ?>

                                            </td>
                                            <td>
                                                <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module")); ?> >
                                                    <?php echo e($workOrderModule->name ?? ''); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module/$submodule->id/detail")); ?> >
                                                    <?php echo e($submodule->name ?? ''); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module/$submodule->id/detail/$detail->id/show")); ?> >
                                                    <?php echo e($detail->name ?? ''); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <?php echo e($submodule->getPicName->display_name ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e(\App\Models\WorkOrderModule::Status_TYPE[$detail->status] ?? ''); ?>

                                            </td>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr data-entry-id="<?php echo e($submodule->id); ?>">
                                        <td>
                                            <?php echo e(++$i); ?>

                                        </td>
                                        <td>
                                            <?php echo e($workOrderModule->getDataDepartment['name'] ?? ''); ?>

                                        </td>
                                        <td>
                                            <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module")); ?> >
                                                <?php echo e($workOrderModule->name ?? ''); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module/$submodule->id/detail")); ?> >
                                                <?php echo e($submodule->name ?? ''); ?>

                                            </a>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <?php echo e($submodule->getPicName->display_name ?? ''); ?>

                                        </td>
                                        <td>
                                            <?php echo e(\App\Models\WorkOrderModule::Status_TYPE[$submodule->status] ?? ''); ?>

                                        </td>

                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr data-entry-id="<?php echo e($workOrderModule->id); ?>">
                                <td>
                                    <?php echo e(++$i); ?>

                                </td>
                                <td>
                                    <?php echo e($workOrderModule->getDataDepartment['name'] ?? ''); ?>

                                </td>
                                <td>
                                    <a href= <?php echo e(url("admin/work-order-module/$workOrderModule->id/sub-module")); ?> >
                                        <?php echo e($workOrderModule->name ?? ''); ?>

                                    </a>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <?php echo e(\App\Models\WorkOrderModule::Status_TYPE[$workOrderModule->status] ?? ''); ?>

                                </td>
                            </tr>
                        <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/all-hierarchy/index.blade.php ENDPATH**/ ?>