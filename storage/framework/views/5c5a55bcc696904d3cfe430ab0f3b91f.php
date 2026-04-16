<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account') && !empty($vender)): ?>
    <div class="row row-gap">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($vender['billing_name'])): ?>
            <div class="col-sm-5 col-12">
                <h6><?php echo e(__('Bill to')); ?></h6>
                <div class="bill-to">
                    <p class="mb-0">
                        <span><?php echo e($vender['billing_name']); ?></span><br>
                        <span><?php echo e($vender['billing_address']); ?></span><br>
                        <span><?php echo e($vender['billing_city'].' , '.$vender['billing_state'].' ,'. $vender['billing_zip']); ?></span><br>
                        <span><?php echo e($vender['billing_country']); ?></span><br>
                        <span><?php echo e($vender['billing_phone']); ?></span><br>
                    </p>
                </div>
            </div>
            <div class="col-sm-5 col-12">
                <h6><?php echo e(__('Ship to')); ?></h6>
                <div class="bill-to">
                    <p class="mb-0">
                        <span><?php echo e($vender['shipping_name']); ?></span><br>
                        <span><?php echo e($vender['shipping_address']); ?></span><br>
                        <span><?php echo e($vender['shipping_city'].' , '.$vender['shipping_state'].' ,'. $vender['shipping_zip']); ?></span><br>
                        <span><?php echo e($vender['shipping_country']); ?></span><br>
                        <span><?php echo e($vender['shipping_phone']); ?></span><br>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-10">
                    <div class="mt-3"><h6><?php echo e($vender['name']); ?></h6><h6><?php echo e($vender['email']); ?></h6></div>
                <h6 class=""><?php echo e(__('Please Set Vendor Shipping And Billing  Details !')); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                        <a href="<?php echo e(route('vendors.index')); ?>"><?php echo e(__('Click Here')); ?></a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </h6>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm btn btn-danger"><?php echo e(__('Remove')); ?></a>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-5">
            <h6 class="mt-5"><?php echo e(__('Please Set vender Details !')); ?>

                <div class="mt-3"><h6><?php echo e($vender['name']); ?></h6><h6><?php echo e($vender['email']); ?></h6></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Account')): ?>
                    <a href="<?php echo e(route('vendors.index')); ?>"><?php echo e(__('Click Here')); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </h6>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm btn  btn-danger"><?php echo e(__(' Remove')); ?></a>
        </div>
        
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\vender_detail.blade.php ENDPATH**/ ?>