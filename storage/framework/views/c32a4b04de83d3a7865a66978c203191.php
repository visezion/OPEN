<?php echo e(Form::open(array('route' => 'faq_store', 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('question', __('Question'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('faq_questions',null, ['class' => 'form-control ', 'placeholder' => __('Enter Question'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('answer', __('Answer'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::textarea('faq_answer', null, ['class' => 'summernote form-control', 'placeholder' => __('Enter Answer'), 'id'=>'summernote','required'=>'required'])); ?>

                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\faq\create.blade.php ENDPATH**/ ?>