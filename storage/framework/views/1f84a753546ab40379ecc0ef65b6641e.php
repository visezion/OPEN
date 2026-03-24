
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Software Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- wrapper start -->
<div class="wrapper">

    <section class="dedicated-themes-section padding-bottom padding-top">
        <div class="container">
            <div class="section-title text-center section">
                <h1 style="font-size: 115px">404</h1>
                <div><?php echo e(__('Ooops!!! The Add on you are looking for is not found')); ?></div>
            </div>
        </div>
    </section>

    <section class="bg-white padding-top padding-bottom ">
        <div class="container">
            <div class="section-title text-center">
                <h2><?php echo e(__('Why Choose a Dedicated Fashion Theme')); ?> <b><?php echo e(__('for Your Business?')); ?></b></h2>
                <p><?php echo e(__('With Alligō, you can take care of the entire partner lifecycle - from onboarding through nurturing, cooperating, and rewarding. Find top performers and let go of those who aren’t a good fit.')); ?></p>
            </div>
            <?php if(count($modules) > 0): ?>
                <div class="row product-row">
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!isset($module->display) || $module->display == true): ?>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 product-card">
                            <div class="product-card-inner">
                                <div class="product-img">
                                    <a href="#">
                                        <img src="assets/images/Custom-Fields.png" alt="">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h4> <a href="#"><?php echo e(isset($module->alias) ? $module->alias :''); ?></a> </h4>
                                    <div class="price">
                                        <ins><span class="currency-type"><?php echo e(super_currency_format_with_sym(ModulePriceByName($module->name)['monthly_price'])); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span></ins>
                                                    <ins><span class="currency-type"><?php echo e(super_currency_format_with_sym(ModulePriceByName($module->name)['yearly_price'])); ?></span> <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span></ins>
                                    </div>
                                    <a href="<?php echo e(route('software.details',$module->alias)); ?>" target="_new"  class="btn cart-btn"><?php echo e(__('View Details')); ?></a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
<!-- wrapper end -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\marketplace\detail_not_found.blade.php ENDPATH**/ ?>