<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add-on Listing')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- wrapper start -->
<div class="wrapper">
    <section class="common-banner-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="common-banner-content">
                        <div class="section-title text-center">
                            <h2><?php echo 'Terms and Conditions'; ?></h2>
                            <p><?php echo 'Our Terms and Conditions page outlines user agreement, data protection policies, payment terms, and intellectual property rights.'; ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-listing-section product-custom-page padding-bottom">
        <div class="container">
            <div class="listing-info padding-top ">
                <?php echo 'Service Agreement: Users agree to abide by the terms outlined in the Service Agreement, which governs the use of WorkDo Dash and its features. Data Protection: WorkDo Dash prioritizes user privacy and data protection, adhering to strict policies and regulations to safeguard sensitive information. Payment Terms: Users are responsible for adhering to the payment terms specified in the agreement, ensuring timely payments for services rendered. Intellectual Property Rights: WorkDo Dash respects intellectual property rights and expects users to do the same, refraining from infringing upon copyrights or trademarks associated with the platform.'; ?> </div>
        </div>
    </section>
</div>
<!-- wrapper end -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\custompage\terms_and_conditions.blade.php ENDPATH**/ ?>