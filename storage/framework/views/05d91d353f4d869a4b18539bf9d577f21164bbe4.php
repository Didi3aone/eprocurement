<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.edit')); ?> <?php echo e(trans('cruds.work-order.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("admin.work-order.update", $workOrder->id)); ?>"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('put'); ?>
                <div class="form-group">
                    <label class="required" for="name">Order Id </label>
                    <input class="form-control <?php echo e($errors->has('work_order_no') ? 'is-invalid' : ''); ?>" type="text"
                           name="work_order_no"
                           id="work_order_no" value="<?php echo e($workOrder->work_order_no); ?>" disabled>
                    <?php if($errors->has('work_order_no')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('work_order_no')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.department')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('departmentId') ? 'is-invalid' : ''); ?>"
                            name="departmentId" id="departmentId" disabled>
                        <option value="">-- Select Department --</option>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($id); ?>"
                                <?php if($workOrder->getWorkOrderModule['departmentId'] === $id): ?>  selected <?php endif; ?>><?php echo e($departments .' - '. $id); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('departmentId')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('departmentId')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.department_helper')); ?></span>
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?php echo e($workOrder->work_order_module_id); ?>" id="work_order_module_id">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.module')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('work_order_module_id') ? 'is-invalid' : ''); ?>"
                            name="work_order_module_id" id="moduleId" disabled>
                        <option value="">-- Select Module --</option>
                    </select>
                    <?php if($errors->has('work_order_module_id')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('work_order_module_id')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <input type="hidden" value="<?php echo e($workOrder->work_order_submodule_id); ?>" id="work_order_sub_module_id">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.sub_module')); ?></label>
                    <select
                        class="form-control select2 <?php echo e($errors->has('work_order_submodule_id') ? 'is-invalid' : ''); ?>"
                        name="work_order_submodule_id" id="submoduleId" disabled>
                        <option value="">-- Select Sub Module --</option>
                    </select>
                    <?php if($errors->has('work_order_submodule_id')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('work_order_submodule_id')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.sub_module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="title"><?php echo e(trans('cruds.work-order.fields.detail')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('work_order_detail_id') ? 'is-invalid' : ''); ?>"
                            name="work_order_detail_id" id="detailId" disabled>
                        <option value="">-- Select Detail --</option>
                    </select>
                    <?php if($errors->has('work_order_detail_id')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('work_order_detail_id')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.sub_module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="title"><?php echo e(trans('cruds.work-order.fields.assigned_to')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('pic') ? 'is-invalid' : ''); ?>"
                            name="pic" id="pic" disabled>
                        <option value="">-- Please Select --</option>
                    </select>
                    <?php if($errors->has('pic')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('[pic]')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.assigned_to_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="title"><?php echo e(trans('cruds.work-order.fields.acknowledge_by')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('boss') ? 'is-invalid' : ''); ?>"
                            name="boss" id="boss" disabled>
                        <option value="">-- Please Select --</option>
                    </select>
                    <?php if($errors->has('boos')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('boss')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.assigned_to_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('global.title')); ?></label>
                    <input class="form-control <?php echo e($errors->has('title') ? 'is-invalid' : ''); ?>" type="text" name="title"
                           id="title" value="<?php echo e($workOrder->title); ?>" disabled>
                    <?php if($errors->has('title')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('title')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="status"><?php echo e(trans('cruds.work-order.fields.priority')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                   name="priority" <?php if($workOrder->priority == 'low'): ?>checked <?php endif; ?>>
                            <label class="form-check-label" for="inline-radio-active">Low</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="2"
                                   name="priority" <?php if($workOrder->priority == 'medium'): ?>checked <?php endif; ?>>
                            <label class="form-check-label" for="inline-radio-non-active">Medium</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="3"
                                   name="priority" <?php if($workOrder->priority == 'high'): ?>checked <?php endif; ?>>
                            <label class="form-check-label" for="inline-radio-non-active">High</label>
                        </div>
                    </div>
                    <?php if($errors->has('priority')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('priority')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.status_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label for="effective_date">Date Promised</label>
                    <input class="form-control date " type="text" name="date_promised" id="date_promised" value="">
                    <?php if($errors->has('date_promised')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('date_promised')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('global.status')); ?></label>
                    <input class="form-control <?php echo e($errors->has('status') ? 'is-invalid' : ''); ?>" type="text"
                           value="Not Started" disabled>
                    <?php if($errors->has('title')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('title')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                    <input type="hidden" name="status" value="In Progress">
                </div>
                <div class="form-group">
                    <label class="required" for="notes"><?php echo e(trans('cruds.work-order.fields.notes')); ?></label>
                    <textarea class="form-control <?php echo e($errors->has('notes') ? 'is-invalid' : ''); ?>"
                              name="notes"
                              id="notes" required> </textarea>
                    <?php if($errors->has('notes')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('notes')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                    <a class="btn btn-default" href="<?php echo e(route('admin.work-order-module.index')); ?>">
                        <?php echo e(trans('global.back_to_list')); ?>

                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function getSubModule() {
            var id = $("#work_order_module_id").val();
            $('#submoduleId').find('option').not(':first').remove();

            $.ajax({
                url: '<?php echo e(url('admin/get-work-order-module-children')); ?>/' + id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    var len = 0;
                    if (response != null) {
                        len = response.length;
                    }

                    var workOrderSubModule = $('work_order_sub_module_id').val();
                    console.log(workOrderSubModule);
                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response[i].id;
                            var name = response[i].name;

                            if (workOrderSubModule === id) {
                                var option = "<option value='" + id + "' selected>" + name + "</option>";
                            } else {
                                var option = "<option value='" + id + "'>" + name + "</option>";
                            }
                            $("#submoduleId").append(option);
                        }
                    }
                }
            });
        }

        $('#submoduleId').change(function () {
            var id = $(this).val();
            $('#detailId').find('option').not(':first').remove();

            $.ajax({
                url: '<?php echo e(url('admin/get-work-order-module-data')); ?>/' + id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    var option = "<option value='" + response.pic + "'>" + response.get_pic_name['display_name'] + "</option>";
                    $("#pic").html(option);

                    var superoption = "<option value='" + response.get_pic_name['get_superior_user']['get_user_supervisor']['person_id'] + "'>" + response.get_pic_name['get_superior_user']['get_user_supervisor']['display_name'] + "</option>";
                    $("#boss").html(superoption);
                }
            });

            $.ajax({
                url: '<?php echo e(url('admin/get-work-order-module-children')); ?>/' + id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    var len = 0;
                    if (response != null) {
                        len = response.length;
                    }

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response[i].id;
                            var name = response[i].name;

                            var option = "<option value='" + id + "'>" + name + "</option>";

                            $("#detailId").append(option);
                        }
                    }
                }
            });
        });

        function getModule() {
            var id = $("#departmentId").val();
            $('#moduleId').find('option').not(':first').remove();

            $.ajax({
                url: '<?php echo e(url('admin/get-work-order-module-by-department')); ?>/' + id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    var len = 0;
                    if (response != null) {
                        len = response.length;
                    }

                    if (len > 0) {
                        var workOrderId = $('#work_order_module_id').val();
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response[i].id;
                            var name = response[i].name;

                            if (workOrderId == id) {
                                var option = "<option value='" + id + "' selected>" + name + "</option>";
                            } else {
                                var option = "<option value='" + id + "'>" + name + "</option>";
                            }
                            $("#moduleId").append(option);
                        }
                    }
                }
            });
        }

        getModule();
        getSubModule();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/list-wo/edit-approve.blade.php ENDPATH**/ ?>