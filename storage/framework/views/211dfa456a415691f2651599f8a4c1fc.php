<?php echo e(Form::open(array('route' => array('buildtech_card_update', $key), 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Heading', __('Heading'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('buildtech_card_heading',$buildtech_card['buildtech_card_heading'], ['class' => 'form-control ', 'placeholder' => __('Enter Heading'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('Description', __('Description'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::textarea('buildtech_card_description', $buildtech_card['buildtech_card_description'], ['class' => 'summernote form-control', 'placeholder' => __('Enter Description'), 'id'=>'buildtech_card','required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <?php echo e(Form::label('More', __('More Details Link'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('buildtech_card_more_details_link',$buildtech_card['buildtech_card_more_details_link'], ['class' => 'form-control ', 'placeholder' => __('Enter Details Link'),'required'=>'required'])); ?>

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?php echo e(Form::label('More Details Link Button Text', __('More Details Link Button Text'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::text('buildtech_card_more_details_button_text',$buildtech_card['buildtech_card_more_details_button_text'], ['class' => 'form-control', 'placeholder' => __('Enter Button Text')])); ?>

                </div>
            </div>

            <div class="col-md-12">

                <div class="form-group">
                    <?php if(check_file($buildtech_card['buildtech_card_logo'])): ?>
                    <?php echo e(Form::label('Logo', __('Logo'), ['class' => 'form-label'])); ?>

                    <div class="logo-content mt-4 pb-5">
                        <img id="image1" src="<?php echo e(get_file($buildtech_card['buildtech_card_logo'])); ?>"
                            class="small-logo"  style="filter: drop-shadow(2px 3px 7px #011C4B);">
                    </div>
                    <?php else: ?>
                    <img id="image1" width="25%" class="mt-3 mb-2">
                    <?php endif; ?>
                    <input type="file" name="buildtech_card_logo" class="form-control"  onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0])" >
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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\buildtech\card_edit.blade.php ENDPATH**/ ?>