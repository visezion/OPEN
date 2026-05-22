<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('site_logo').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                document.getElementById('image').src = src
            }
    </script>
<?php $__env->stopPush(); ?>

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
            <?php echo $__env->make('landingpage::landingpage.custom.sitesettings.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('landingpage::landingpage.custom.footer.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('landingpage::landingpage.custom.custom_js_css.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('landingpage::landingpage.custom.google_fonts.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\custom\index.blade.php ENDPATH**/ ?>