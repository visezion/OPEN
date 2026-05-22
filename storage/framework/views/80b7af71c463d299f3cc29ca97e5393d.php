<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <a class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Qr Code')); ?>" data-bs-toggle="modal"  data-bs-target="#qrcodeModal" id="download-qr"
        target="_blanks" >
        <span class="text-white"><i class="fa fa-qrcode"></i></span>
    </a>
    <a class="btn btn-sm btn-primary btn-icon ml-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
    data-bs-original-title="<?php echo e(__('Preview')); ?>" href="<?php echo e(url('/')); ?>" target="-blank" ><span
    class="text-white"><i class="ti ti-eye"></i></span></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $__env->make('landingpage::landingpage.sections', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            <?php echo e(Form::open(['route' => ['landingpage.cookie.setting.store'],'method'=>'post','class'=>'needs-validation', 'novalidate'])); ?>

                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5><?php echo e(__('Custom')); ?></h5>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 text-end">
                                <div class="form-check form-switch custom-switch-v1 float-end">
                                    <input type="checkbox" name="enable_cookie" class="form-check-input input-primary" id="enable_cookie"
                                        <?php echo e((isset($settings['enable_cookie']) ? $settings['enable_cookie'] :'off') == 'on' ? ' checked ' : ''); ?>>
                                    <label class="form-check-label" for="enable_cookie"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row border p-2">
                            <div class="col-md-6">
                                <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                    <input type="checkbox" name="cookie_logging" class="form-check-input input-primary cookie_setting"
                                        id="cookie_logging" <?php echo e((isset($settings['cookie_logging']) ? $settings['cookie_logging'] :'off') == 'on' ? ' checked ' : ''); ?>>
                                    <label class="form-check-label" for="cookie_logging"><?php echo e(__('Enable logging')); ?></label>
                                    <small class="text-danger"><?php echo e(__('After enabling logging, user cookie data will be stored in CSV file.')); ?></small>
                                </div>
                                <div class="form-group" >
                                    <?php echo e(Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label' ])); ?>

                                    <?php echo e(Form::text('cookie_title',!empty($settings['cookie_title']) ? $settings['cookie_title'] : null , ['class' => 'form-control cookie_setting','placeholder' => 'Enter Cookie Title'] )); ?>

                                </div>
                                <div class="form-group ">
                                    <?php echo e(Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label'])); ?>

                                    <?php echo Form::textarea('cookie_description',!empty($settings['cookie_description']) ? $settings['cookie_description'] : null , ['class' => 'form-control cookie_setting', 'rows' => '3','placeholder' => 'Enter Cookie Description']); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch custom-switch-v1 ">
                                    <input type="checkbox" name="necessary_cookies" class="form-check-input input-primary cookie_setting"
                                        id="necessary_cookies" checked onclick="return false">
                                    <label class="form-check-label" for="necessary_cookies"><?php echo e(__('Strictly necessary cookies')); ?></label>
                                </div>
                                <div class="form-group ">
                                    <?php echo e(Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label'])); ?>

                                    <?php echo e(Form::text('strictly_cookie_title',!empty($settings['strictly_cookie_title']) ? $settings['strictly_cookie_title'] : null , ['class' => 'form-control cookie_setting','placeholder' => 'Enter Strictly Cookie Title'])); ?>

                                </div>
                                <div class="form-group ">
                                    <?php echo e(Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label'])); ?>

                                    <?php echo Form::textarea('strictly_cookie_description',!empty($settings['strictly_cookie_description']) ? $settings['strictly_cookie_description'] : null , ['class' => 'form-control cookie_setting ', 'rows' => '3','placeholder' => 'Enter Strictly Cookie Description']); ?>

                                </div>
                            </div>
                            <div class="col-12">
                                <h5><?php echo e(__('More Information')); ?></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label'])); ?>

                                    <?php echo e(Form::text('more_information_description',!empty($settings['more_information_description']) ? $settings['more_information_description'] : null , ['class' => 'form-control cookie_setting','placeholder' => 'Enter Contact Us Description'])); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <?php echo e(Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label'])); ?>

                                    <?php echo e(Form::text('contactus_url',!empty($settings['contactus_url']) ? $settings['contactus_url'] : null , ['class' => 'form-control cookie_setting','placeholder' => 'Enter Contact Us URL'])); ?>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary"><?php echo e(__('Save Changes')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo e(Form::close()); ?>

            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\cookie\index.blade.php ENDPATH**/ ?>