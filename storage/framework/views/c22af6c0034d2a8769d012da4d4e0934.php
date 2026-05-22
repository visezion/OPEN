<?php echo e(Form::open(array('route' => array('marketplace_screenshots_store',$slug), 'method'=>'post', 'enctype' => "multipart/form-data",'class'=>'needs-validation', 'novalidate'))); ?>

    <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Heading', __('Heading'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('screenshots_heading',null, ['class' => 'form-control ', 'placeholder' => __('Enter Heading'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('screenshots', __('Screenshots'), ['class' => 'form-label'])); ?>

                    <input type="file" name="screenshots" class="form-control" required>
                </div>
            </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\marketplace\screenshots\create.blade.php ENDPATH**/ ?>