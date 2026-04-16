<?php
    $logo = asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/');
?>
<div class="modal-header pb-2 pt-2">
    <h5 class="modal-title" id="exampleModalLongTitle"> </h5>
   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body p-1">
      <div class="row ">
        <div class="col-lg-12 product-left mb-5 mb-lg-0">
            <div class="swiper-container product-slider mb-2 pb-2">


                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slug == 'landingpage'): ?>
                    <div class="swiper-wrapper">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section == 'home'): ?>
                        <div class="swiper-slide" id="slide-1">
                            <img src="<?php echo e(get_file($logo.'/home.png')); ?>" class="img-fluid" alt="Home Section">
                        </div>
                        <?php elseif($section == 'features'): ?>
                        <div class="swiper-slide" id="slide-2">
                            <img src="<?php echo e(get_file($logo.'/featurecards.png')); ?>" class="img-fluid" alt="Feature Cards Section">
                        </div>
                        <div class="swiper-slide" id="slide-3">
                            <img src="<?php echo e(get_file($logo.'/featuresections.png')); ?>" class="img-fluid" alt="Feature Section">
                        </div>
                        <?php elseif($section == 'review'): ?>

                        <div class="swiper-slide" id="slide-4">
                            <img src="<?php echo e(get_file($logo.'/reviewsection.png')); ?>" class="img-fluid" alt="Review Section">
                        </div>
                        <?php elseif($section == 'screenshots'): ?>

                        <div class="swiper-slide" id="slide-5">
                            <img src="<?php echo e(get_file($logo.'/screenshotsection.png')); ?>" class="img-fluid" alt="Screenshots Section">
                        </div>
                        <?php elseif($section == 'dedicated'): ?>

                        <div class="swiper-slide" id="slide-6">
                            <img src="<?php echo e(get_file($logo.'/dedicationsectiondetails.png')); ?>" class="img-fluid" alt="Dedicated Details">
                        </div>
                        <div class="swiper-slide" id="slide-7">
                            <img src="<?php echo e(get_file($logo.'/dedicatedsectioncards.png')); ?>" class="img-fluid" alt="Dedicated Cards">
                        </div>
                        <?php elseif($section == 'buildtech'): ?>

                        <div class="swiper-slide" id="slide-8">
                            <img src="<?php echo e(get_file($logo.'/buildtechsectiondetails.png')); ?>" class="img-fluid" alt="Buildtech Details">
                        </div>
                        <div class="swiper-slide" id="slide-9">
                            <img src="<?php echo e(get_file($logo.'/buildtechsectioncards.png')); ?>" class="img-fluid" alt="Buildtech Cards">
                        </div>
                        <?php elseif($section == 'package'): ?>

                        <div class="swiper-slide" id="slide-10">
                            <img src="<?php echo e(get_file($logo.'/packagedetailssection.png')); ?>" class="img-fluid" alt="Package Details">
                        </div>
                        <?php elseif($section == 'footer'): ?>

                        <div class="swiper-slide" id="slide-11">
                            <img src="<?php echo e(get_file($logo.'/footersection.png')); ?>" class="img-fluid" alt="Footer Section">
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="swiper-wrapper">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section == 'product_main'): ?>

                        <div class="swiper-slide" id="slide-1">
                            <img src="<?php echo e(get_file($logo.'/product_main.png')); ?>" class="img-fluid" alt="Home Section">
                        </div>
                        <?php elseif($section == 'dedicated'): ?>

                        <div class="swiper-slide" id="slide-2">
                            <img src="<?php echo e(get_file($logo.'/dedicated.png')); ?>" class="img-fluid" alt="Feature Cards Section">
                        </div>
                        <?php elseif($section == 'whychoose'): ?>

                        <div class="swiper-slide" id="slide-3">
                            <img src="<?php echo e(get_file($logo.'/whychoose.png')); ?>" class="img-fluid" alt="Feature Section">
                        </div>
                        <?php elseif($section == 'screenshots'): ?>

                        <div class="swiper-slide" id="slide-4">
                            <img src="<?php echo e(get_file($logo.'/screenshots.png')); ?>" class="img-fluid" alt="Review Section">
                        </div>
                        <?php elseif($section == 'addon'): ?>

                        <div class="swiper-slide" id="slide-5">
                            <img src="<?php echo e(get_file($logo.'/addon.png')); ?>" class="img-fluid" alt="Screenshots Section">
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
      </div>
  </div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\layouts\infoimages.blade.php ENDPATH**/ ?>