

    
    <a href="<?php echo e(route('landingpage.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landingpage.index') ? ' active' : ''); ?>"><?php echo e(__('Details')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    <a href="<?php echo e(route('landingpage.custom')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landingpage.custom') ? ' active' : ''); ?>"><?php echo e(__('Custom')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    <a href="<?php echo e(route('join_us.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'join_us.index') ? ' active' : ''); ?>"><?php echo e(__('Newsletter')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    
    <a href="<?php echo e(route('landing.change.blocks')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landing.change.blocks') ? ' active' : ''); ?>"><?php echo e(__('Change Blocks')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    <a href="<?php echo e(route('landing.seo')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landing.seo') ? ' active' : ''); ?>"><?php echo e(__('SEO')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    <a href="<?php echo e(route('landing.pwa')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landing.pwa') ? ' active' : ''); ?>"><?php echo e(__('PWA')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    <a href="<?php echo e(route('landing.cookie')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landing.cookie') ? ' active' : ''); ?>"><?php echo e(__('Cookie')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    
    <a href="<?php echo e(route('landing.qrCode')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'landing.qrCode') ? ' active' : ''); ?>"><?php echo e(__('QR Code')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    

    <div class="modal fade" id="exampleModalCenter" tabindex="2" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl ss_modale" role="document">
            <div class="modal-content image_sider_div">
            </div>
        </div>
    </div>

    <?php $__env->startPush('css'); ?>
        <?php echo $__env->make('landingpage::layouts.infoimagescss', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <?php echo $__env->make('landingpage::layouts.infoimagesjs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\layouts\tab.blade.php ENDPATH**/ ?>