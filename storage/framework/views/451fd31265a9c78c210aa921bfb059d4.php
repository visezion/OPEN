<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $__env->make('landingpage::marketplace.modules', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card sticky-top" style="top:30px">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                <?php echo $__env->make('landingpage::marketplace.tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h5><?php echo e(__('Add On Head details')); ?></h5>
                                </div>
                                <div id="p1" class="col-auto text-end text-primary h3">
                                    <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/addon.png')); ?>"
                                       data-url="<?php echo e(route('info.image.view',['marketplace','addon'])); ?>" class="view-images pt-2">
                                        <i class="ti ti-info-circle pointer"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::open(array('route' => array('addon_store',$slug), 'method'=>'post', 'enctype' => "multipart/form-data",'class'=>'needs-validation', 'novalidate'))); ?>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php echo e(Form::label('Heading', __('Heading'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('addon_heading',$settings['addon_heading'], ['class' => 'form-control ', 'placeholder' => __('Enter Heading')])); ?>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php echo e(Form::label('Description', __('Description'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::textarea('addon_description', $settings['addon_description'], ['class' => 'summernote form-control', 'placeholder' => __('Enter Description'), 'id'=>'addon_description','required'=>'required'])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                            </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                    
                    </div>
                </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\marketplace\addon\index.blade.php ENDPATH**/ ?>