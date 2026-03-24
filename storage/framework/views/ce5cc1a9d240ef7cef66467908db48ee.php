<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <a class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Qr Code')); ?>"  data-bs-toggle="modal"  data-bs-target="#qrcodeModal" id="download-qr"
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
            <?php echo $__env->make('landingpage::landingpage.sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <div class="card mt-4">
                <?php echo e(Form::model($settings, ['route' => ['landingpage.pwa.setting.save'], 'method' => 'POST', 'enctype' => 'multipart/form-data','class'=>'needs-validation', 'novalidate'])); ?>

                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5><?php echo e(__('PWA')); ?></h5>
                        </div>
                        <div id="p1" class="col-auto text-end text-primary">
                            <div class="form-group col-md-4 ">
                                <label class="form-check-label"
                                    for="is_checkout_login_required"></label>
                                <div class="custom-control form-switch">
                                    <input type="checkbox"
                                        class="form-check-input is_pwa_store_active" name="is_pwa_store_active"
                                        id="pwa_store"
                                        <?php echo e(!empty($settings['is_pwa_store_active']) && $settings['is_pwa_store_active'] == 'on' ? 'checked=checked' : ''); ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="border">

                            <div class="p-3 justify-content-center">

                                <div class="row">
                                    <div class="form-group col-md-6 pwa_is_enable">
                                        <?php echo e(Form::label('pwa_app_title', __('App Title'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('pwa_app_title', !empty($pwa->name) ? $pwa->name : '', ['class' => 'form-control','required'=>'required', 'placeholder' => __('App Title')])); ?>

                                    </div>

                                    <div class="form-group col-md-6 pwa_is_enable">
                                        <?php echo e(Form::label('pwa_app_name', __('App Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('pwa_app_name', !empty($pwa->short_name) ? $pwa->short_name : '', ['class' => 'form-control','required'=>'required', 'placeholder' => __('App Name')])); ?>

                                    </div>

                                    <div class="form-group input-width col-md-6 pwa_is_enable">
                                        <?php echo e(Form::label('pwa_app_background_color', __('App Background Color'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::color('pwa_app_background_color', !empty($pwa->background_color) ? $pwa->background_color : '', ['class' => 'form-control color-picker', 'placeholder' => __('18761234567')])); ?>

                                    </div>

                                    <div class="form-group input-width col-md-6 pwa_is_enable">
                                        <?php echo e(Form::label('pwa_app_theme_color', __('App Theme Color'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::color('pwa_app_theme_color', !empty($pwa->theme_color) ? $pwa->theme_color : '', ['class' => 'form-control color-picker', 'placeholder' => __('18761234567')])); ?>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save Changes')); ?></button>
                                </div>
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


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\pwa\index.blade.php ENDPATH**/ ?>