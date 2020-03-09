<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.work-order.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("admin.work-order.store")); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.department')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('departmentId') ? 'is-invalid' : ''); ?>"
                            name="departmentId" id="departmentId" required>
                        <option value="">-- Select Department --</option>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($id); ?>" <?php echo e(in_array($id, old('departmentId', [])) ? 'selected' : ''); ?>><?php echo e($departments .' - '. $id); ?></option>
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
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.module')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('work_order_module_id') ? 'is-invalid' : ''); ?>"
                            name="work_order_module_id" id="moduleId" required>
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
                    <label class="required" for="title"><?php echo e(trans('cruds.work-order.fields.sub_module')); ?></label>
                    <select
                        class="form-control select2 <?php echo e($errors->has('work_order_submodule_id') ? 'is-invalid' : ''); ?>"
                        name="work_order_submodule_id" id="submoduleId" required>
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
                            name="work_order_detail_id" id="detailId" required>
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
                           id="title" value="<?php echo e(old('title', '')); ?>" required>
                    <?php if($errors->has('title')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('title')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('global.description')); ?></label>
                    <textarea class="form-control <?php echo e($errors->has('description') ? 'is-invalid' : ''); ?>"
                              name="description"
                              id="description" value="<?php echo e(old('description', '')); ?>" required> </textarea>
                    <?php if($errors->has('description')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('description')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="status"><?php echo e(trans('cruds.work-order.fields.priority')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="1"
                                   name="priority" checked>
                            <label class="form-check-label" for="inline-radio-active">Low</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="2"
                                   name="priority">
                            <label class="form-check-label" for="inline-radio-non-active">Medium</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="3"
                                   name="priority">
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
                    <label class="required" for="name"><?php echo e(trans('global.status')); ?></label>
                    <input class="form-control <?php echo e($errors->has('status') ? 'is-invalid' : ''); ?>" type="text"
                           name="status"
                           id="status" value="Not Started" disabled>
                    <?php if($errors->has('title')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('title')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.module_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="name"><?php echo e(trans('cruds.work-order.fields.upload_file')); ?></label>
                    <input class="form-control <?php echo e($errors->has('file_uploads') ? 'is-invalid' : ''); ?>" type="file"
                           name="file_uploads"
                           id="file_uploads" multiple>
                    <?php if($errors->has('file_uploads')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('file_uploads')); ?>

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
        $('#moduleId').change(function () {
            var id = $(this).val();
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

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response[i].id;
                            var name = response[i].name;

                            var option = "<option value='" + id + "'>" + name + "</option>";

                            $("#submoduleId").append(option);
                        }
                    }
                }
            });
        });

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

        $('#departmentId').change(function () {
            var id = $(this).val();
            $('#moduleId').find('option').not(':first').remove();

            $.ajax({
                url: '<?php echo e(url('admin/get-work-order-module-by-department')); ?>/' + id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
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

                            $("#moduleId").append(option);
                        }
                    }
                }
            });
        });

        CKEDITOR.replace('description');
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/work-order/list-wo/create.blade.php ENDPATH**/ ?>