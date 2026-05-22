<?php echo e(Form::open(array('route' => 'review_store', 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Header Tag', __('Header Tag'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('review_header_tag',null, ['class' => 'form-control ', 'placeholder' => __('Enter Header Tag'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Heading', __('Heading'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('review_heading',null, ['class' => 'form-control ', 'placeholder' => __('Enter Heading'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Description', __('Description'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::textarea('review_description',null, ['class' => 'summernote form-control', 'placeholder' => __('Enter Description'), 'id'=>'review_description','required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <?php echo e(Form::label('Live Demo button Link', __('Live Demo button Link'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('review_live_demo_link',null, ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('Live Demo Button Text', __('Live Demo Button Text'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('review_live_demo_button_text',null, ['class' => 'form-control', 'placeholder' => __('Enter Button Text')])); ?>

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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\reviews\create.blade.php ENDPATH**/ ?>