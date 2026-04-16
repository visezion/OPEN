
<a href="<?php echo e(route('marketplace_product',$slug)); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'marketplace_product') ? ' active' : ''); ?><?php echo e((Request::route()->getName() == 'marketplace.index') ? ' active' : ''); ?>"><?php echo e(__('Product Main')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

<a href="<?php echo e(route('marketplace_dedicated',$slug)); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'marketplace_dedicated') ? ' active' : ''); ?>"><?php echo e(__('Dedicated Section')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

<a href="<?php echo e(route('marketplace_whychoose',$slug)); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'marketplace_whychoose') ? ' active' : ''); ?>"><?php echo e(__('Why Choose')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

<a href="<?php echo e(route('marketplace_screenshot',$slug)); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'marketplace_screenshot') ? ' active' : ''); ?>"><?php echo e(__('Screenshots')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

<a href="<?php echo e(route('marketplace_addon',$slug)); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'marketplace_addon') ? ' active' : ''); ?>"><?php echo e(__('Add-On')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>


<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('landingpage::layouts.infoimagescss', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('landingpage::layouts.infoimagesjs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl ss_modale" role="document">
        <div class="modal-content image_sider_div">
            
        </div>
    </div>
</div>




<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\marketplace\tab.blade.php ENDPATH**/ ?>