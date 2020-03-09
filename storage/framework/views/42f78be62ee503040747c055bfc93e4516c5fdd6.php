<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.document.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("admin.document.store")); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="required" for="name"><?php echo e(trans('cruds.document.fields.name')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name" id="name" value="<?php echo e(old('name', '')); ?>" required>
                    <?php if($errors->has('name')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('name')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.name_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="category_id"><?php echo e(trans('cruds.document-category.fields.category')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('category_id') ? 'is-invalid' : ''); ?>" name="category_id" id="category_id">
                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($row->id); ?>" <?php echo e(in_array($row->id, old('category_id', [])) ? 'selected' : ''); ?>><?php echo e($row->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('category_id')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('category_id')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.person_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="company_id"><?php echo e(trans('cruds.document.fields.company_id')); ?></label>
                    <select class="form-control select2 <?php echo e($errors->has('company_id') ? 'is-invalid' : ''); ?>" name="company_id" id="company_id">
                        <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $company_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(in_array($id, old('company_id', [])) ? 'selected' : ''); ?>><?php echo e($company_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('company_id')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('company_id')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.company_id_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="required" for="expired_date"><?php echo e(trans('cruds.document.fields.expired_date')); ?></label>
                    <input class="form-control <?php echo e($errors->has('expired_date') ? 'is-invalid' : ''); ?>" type="date" name="expired_date" id="expired_date" value="<?php echo e(old('expired_date', '')); ?>" required>
                    <?php if($errors->has('expired_date')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('expired_date')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.expired_date_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="type"><?php echo e(trans('cruds.document.fields.type')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="All"
                                   name="type" checked >
                            <label class="form-check-label" for="inline-radio-active"><?php echo e(trans('cruds.document.fields.all')); ?></label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="Department"
                                   name="type">
                            <label class="form-check-label" for="inline-radio-non-active"><?php echo e(trans('cruds.document.fields.department')); ?></label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="Person"
                                   name="type">
                            <label class="form-check-label" for="inline-radio-non-active"><?php echo e(trans('cruds.document.fields.person')); ?></label>
                        </div>
                    </div>
                    <?php if($errors->has('type')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('type')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.status_helper')); ?></span>
                </div>
                <div class="form-group" id="dept">
                    <label class="" for="title"><?php echo e(trans('cruds.document.fields.departmentId')); ?></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all')); ?></span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all')); ?></span>
                    </div>
                    <select class="form-control select2 <?php echo e($errors->has('departmentId') ? 'is-invalid' : ''); ?>" name="departmentId[]" id="departmentId" multiple>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(in_array($id, old('departmentId', [])) ? 'selected' : ''); ?>><?php echo e($departments .' - '. $id); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('departmentId')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('departmentId')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.department_helper')); ?></span>
                </div>
                <div class="form-group" id="person">
                    <label class="" for="person"><?php echo e(trans('cruds.document.fields.person')); ?></label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all')); ?></span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all')); ?></span>
                    </div>
                    <select class="form-control select2 <?php echo e($errors->has('person') ? 'is-invalid' : ''); ?>" name="person[]" id="roles" multiple>
                        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nik): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($nik->person_id); ?>" <?php echo e(in_array($nik->person_id, old('person', [])) ? 'selected' : ''); ?>><?php echo e($nik->person_id." - ".$nik->display_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if($errors->has('person')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('person')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.person_helper')); ?></span>
                </div>
                <div class="form-group">
                    <label class="" for="type"><?php echo e(trans('cruds.document.fields.access_file')); ?></label>
                    <div class="">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-active" type="radio" value="R"
                                   name="access_file" checked >
                            <label class="form-check-label" for="inline-radio-active"><?php echo e(trans('cruds.document.fields.readOnly')); ?></label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio-non-active" type="radio" value="RD"
                                   name="access_file">
                            <label class="form-check-label" for="inline-radio-non-active"><?php echo e(trans('cruds.document.fields.readNdownload')); ?></label>
                        </div>
                    </div>
                    <?php if($errors->has('type')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('type')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.work-order.fields.status_helper')); ?></span>
                </div>
                <div class="input-group mb-3 img_div">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?php echo e(trans('cruds.document.fields.file')); ?></span>
                    </div>
                    <input type="file" name="file[]" class="form-control <?php echo e($errors->has('file') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('file', '')); ?>" aria-label="Upload File" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success btn-add-more" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                    <?php if($errors->has('file')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('file')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.file_helper')); ?></span>
                </div>
                <div class="clone hide">
                    <div class="control-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?php echo e(trans('cruds.document.fields.file')); ?></span>
                        </div>
                        <input type="file" name="file[]" runat="server"  ID="fileSelect" accept=".pdf" class="form-control <?php echo e($errors->has('file') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('file', '')); ?>" aria-label="Upload File" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-danger btn-remove" type="button"><i class="fa fa-minus"></i></button>
                        </div>
                        <?php if($errors->has('file')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('file')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.document.fields.file_helper')); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="" for="description"><?php echo e(trans('cruds.document.fields.description')); ?></label>
                    <textarea class="form-control <?php echo e($errors->has('description') ? 'is-invalid' : ''); ?>" name="description"> <?php echo e(old('description', '')); ?> </textarea>
                    <?php if($errors->has('description')): ?>
                        <div class="invalid-feedback">
                            <?php echo e($errors->first('description')); ?>

                        </div>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.document.fields.name_helper')); ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                    <a class="btn btn-default" href="<?php echo e(route('admin.document.index')); ?>">
                        <?php echo e(trans('global.back_to_list')); ?>

                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <script>
        $(document).ready(function() {
            $(".hide").hide();
            $("#dept").hide();
            $("#person").hide();

            $("input[name='type']").change(function(){
                var tipe = $(this).val();

                if( tipe == 'All' ) {
                    $("#dept").hide();
                    $("#person").hide();
                } else if( tipe == 'Department' ) {
                    $("#dept").show();
                    $("#person").hide();
                } else {
                    $("#dept").hide();
                    $("#person").show();
                }
            });
            $(".btn-add-more").click(function(){ 
                var html = $(".clone").html();
                $(".img_div").after(html);
            });

            $("body").on("click",".btn-remove",function(){ 
                $(this).parents(".control-group").remove();
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/master-document/document/create.blade.php ENDPATH**/ ?>