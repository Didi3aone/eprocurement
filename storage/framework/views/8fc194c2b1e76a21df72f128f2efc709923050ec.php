<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            <?php echo e(session('status')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route("admin.document.create")); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.document.fields.document')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <?php echo e(trans('cruds.document.title_singular')); ?> <?php echo e(trans('global.list')); ?>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            <?php echo e(trans('cruds.document.fields.id')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.doc_category')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.company_id')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.name')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.created_by')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.type')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.created_at')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.expired_date')); ?>

                        </th>

                        <th>
                            <?php echo e(trans('cruds.document.fields.file')); ?>

                        </th>

                        
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $Document; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <tr data-entry-id="<?php echo e($rows['id']); ?>">
                                <td>

                                </td>
                                <td>
                                    <?php echo e($rows['code']); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['category']['name'] ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['get_company']['name'] ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['name']); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['owner']['name'] ?? ''); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['type']); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['created_at']); ?>

                                </td>
                                <td>
                                    <?php echo e($rows['expired_date']); ?>

                                </td>
                                <td>
                                    <a class="btn btn-xs btn-success"  data-toggle="modal" data-target="#exampleModal-<?php echo e($key); ?>">Show File</a>
                                    <!-- Modal -->
                                    <div class="modal fade modal bd-example-modal-lg" id="exampleModal-<?php echo e($key); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo e(trans('cruds.document.fields.file_name')); ?></th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $rows['document_file']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($value['file']); ?></td>
                                                                    <td>
                                                                        <?php if($rows['access_file'] == "RD" ): ?>  
                                                                            <a class="btn btn-xs btn-primary"  target="_blank" download="<?php echo e(asset("master-document/".$value['file'])); ?>" href="<?php echo e(asset("master-document/".$value['file'])); ?>"><i class="fa fa-download"> Download</i></a>
                                                                            <a class="btn btn-xs btn-success" target="_blank" href="<?php echo e(route('admin.get-file-storage-preview', $value['file'])); ?>"><i class="fa fa-eye"> Preview</i></a>
                                                                        <?php elseif($rows['access_file'] == "R"): ?>
                                                                            <a class="btn btn-xs btn-success" target="_blank" href="<?php echo e(route('admin.get-file-storage-preview', $value['file'])); ?>"><i class="fa fa-eye"> Preview</i></a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/master-document/document/index.blade.php ENDPATH**/ ?>