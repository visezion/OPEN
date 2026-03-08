<?php echo e(Form::model($addon, ['route' => ['add-one.detail.save', $addon->id], 'method' => 'post','enctype'=>'multipart/form-data'])); ?>

<div class="modal-body">
    <div class="form-group mb-1">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Permission Name')])); ?>

        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-name" role="alert">
                <strong class="text-danger"><?php echo e($message); ?></strong>
            </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('monthly_price', __('Price/Month'), ['class' => 'col-form-label'])); ?>

                <div class="input-group">
                    <?php echo e(Form::number('monthly_price', null, ['class' => 'form-control','step' => '0.1','placeholder' => __('Enter Price for Month')])); ?>

                    <span class="input-group-text"><?php echo e(company_setting('defult_currancy_symbol')); ?></span>
                </div>
                <small><?php echo e(__('0 To module is free')); ?></small>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('yearly_price', __('Price/Year'), ['class' => 'col-form-label'])); ?>

                <div class="input-group">
                    <?php echo e(Form::number('yearly_price', null, ['class' => 'form-control','step' => '0.1','placeholder' => __('Enter Price for Year')])); ?>

                    <span class="input-group-text"><?php echo e(company_setting('defult_currancy_symbol')); ?></span>
                </div>
                <small><?php echo e(__('0 To module is free')); ?></small>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="col-form-label"><?php echo e(__('Logo')); ?></label>
                <div class="choose-files">
                    <label for="module_logo">
                        <div class=" bg-primary "> <i class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?></div>
                        <input type="file" class="form-control file" accept="image/png, image/jpeg, image/jpg" name="module_logo" id="module_logo" data-filename="module_logo_update" onchange="document.getElementById('blah6').src = window.URL.createObjectURL(this.files[0])">
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <img id="blah6" class="mt-3" src="<?php echo e(!empty($addon->image) ? get_file($addon->image) : url('/packages/workdo/' . $addon->module . '/favicon.png')); ?>"  width="30%"/>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Save'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\plans\module_detail.blade.php ENDPATH**/ ?>