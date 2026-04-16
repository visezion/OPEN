<?php echo e(Form::model($pixel, ['route' => ['landingpagePixel.update', $pixel->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate'])); ?>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('platform', __('Platform'),['class'=>'form-label'])); ?>

                    <?php echo Form::select('platform', $pixals_platforms, null,array('class' => 'form-control select2','required'=>'required')); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('pixel_id',__('Pixel ID'))); ?>

                    <?php echo e(Form::text('pixel_id',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Pixel ID')))); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>


<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\seo\edit.blade.php ENDPATH**/ ?>