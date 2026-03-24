<?php
    $description = trim((string) ($module->description ?? ''));
    if ($description === '') {
        $description = __('This add-on is installed and available in the system, but it does not include a custom marketplace detail page. Use the links below to explore pricing or continue to the add-on catalog.');
    }

    $screenshots = $marketplaceAssets ?? [];
    $heroImage = $screenshots[0] ?? ($module->image ?? null);
    $galleryImages = count($screenshots) > 1 ? array_slice($screenshots, 1) : [];
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Software Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="wrapper">
        <section class="product-main-section padding-bottom padding-top">
            <div class="offset-container offset-left">
                <div class="row row-gap align-items-center pdp-summery-row">
                    <div class="col-lg-6 col-md-6 col-12 pdp-left-side">
                        <div class="pdp-summery">
                            <div class="section-title">
                                <div class="subtitle"><?php echo e(__('Add-on')); ?></div>
                                <h2><?php echo e($module->alias); ?></h2>
                            </div>
                            <p><?php echo e($description); ?></p>
                            <div class="price">
                                <ins>
                                    <span class="currency-type"><?php echo e(super_currency_format_with_sym($module->monthly_price ?? 0)); ?></span>
                                    <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span>
                                </ins>
                                <ins>
                                    <span class="currency-type"><?php echo e(super_currency_format_with_sym($module->yearly_price ?? 0)); ?></span>
                                    <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span>
                                </ins>
                            </div>
                            <div class="cart-view btn-group">
                                <a href="<?php echo e(route('apps.pricing')); ?>" class="btn-secondary"><?php echo e(__('Buy Now')); ?></a>
                                <a href="<?php echo e(route('apps.software')); ?>" class="link-btn"><?php echo e(__('Browse Add-ons')); ?></a>
                            </div>
                            <div class="mt-4">
                                <p class="mb-1"><strong><?php echo e(__('Module')); ?>:</strong> <?php echo e($module->name); ?></p>
                                <p class="mb-1"><strong><?php echo e(__('Package Namespace')); ?>:</strong> <?php echo e($module->package_name ?? __('N/A')); ?></p>
                                <p class="mb-0"><strong><?php echo e(__('Version')); ?>:</strong> <?php echo e($module->version ?? '1.0'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 pdp-left-side">
                        <div class="pdp-image-wrapper">
                            <div class="pdp-media banner-img-wrapper">
                                <?php if(!empty($heroImage)): ?>
                                    <img src="<?php echo e($heroImage); ?>" alt="<?php echo e($module->alias); ?>" class="inner-frame-img">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('market_assets/images/banner-image.png')); ?>" alt="<?php echo e($module->alias); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if(count($galleryImages) > 0): ?>
            <section class="screenshot-section padding-top padding-bottom">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php echo e(__('Screenshots')); ?></h2>
                    </div>
                    <div class="screenshot-slider">
                        <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="screenshot-itm">
                                <div class="screenshot-image">
                                    <a href="<?php echo e($image); ?>" target="_blank" class="img-zoom">
                                        <img src="<?php echo e($image); ?>" alt="<?php echo e($module->alias); ?>">
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="bg-white padding-top padding-bottom">
            <div class="container">
                <div class="section-title text-center">
                    <h2><?php echo e(__('Explore More Add-ons')); ?></h2>
                    <p><?php echo e(__('Browse other installed modules from the marketplace catalog.')); ?></p>
                </div>
                <?php if(count($modules) > 0): ?>
                    <div class="row product-row">
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 product-card">
                                <div class="product-card-inner">
                                    <div class="product-img">
                                        <a href="<?php echo e(route('software.details', $relatedModule->alias)); ?>">
                                            <img src="<?php echo e($relatedModule->image); ?>" alt="<?php echo e($relatedModule->alias); ?>">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="<?php echo e(route('software.details', $relatedModule->alias)); ?>"><?php echo e($relatedModule->alias); ?></a>
                                        </h4>
                                        <div class="price">
                                            <ins>
                                                <span class="currency-type"><?php echo e(super_currency_format_with_sym($relatedModule->monthly_price ?? 0)); ?></span>
                                                <span class="time-lbl text-muted"><?php echo e(__('/Month')); ?></span>
                                            </ins>
                                            <ins>
                                                <span class="currency-type"><?php echo e(super_currency_format_with_sym($relatedModule->yearly_price ?? 0)); ?></span>
                                                <span class="time-lbl text-muted"><?php echo e(__('/Year')); ?></span>
                                            </ins>
                                        </div>
                                        <a href="<?php echo e(route('software.details', $relatedModule->alias)); ?>" class="btn cart-btn"><?php echo e(__('View Details')); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/marketplace/detail.blade.php ENDPATH**/ ?>