<div class="modal-body">
    <div class="row">
        <div class=" col-12">
            <div class="row mt-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-12">
                        <div class="card border-grey">
                            <div class="card-body text-center">
                                <h5><?php echo e($plan->name); ?></h5>
                                <h6><?php echo e(super_currency_format_with_sym($plan->package_price_monthly) . ' / Per Month'); ?>

                                </h6>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plan->id == $user->active_plan): ?>
                                    <a href="#"
                                        class="btn btn-sm btn-primary my-auto w-100 d-flex align-items-center justify-content-center gap-2"
                                        title="<?php echo e(__('Click to Upgrade Plan')); ?>">
                                        <i class="ti ti-check "></i>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('plan.details', [Crypt::encrypt($plan->id), Crypt::encrypt($user->id)])); ?>"
                                        class="btn btn-sm btn-warning my-auto w-100 d-flex align-items-center justify-content-center gap-2"
                                        title="<?php echo e(__('Click to Upgrade Plan')); ?>">
                                        <i class="ti ti-shopping-cart-plus"></i>
                                        <?php echo e(__('Assign')); ?>

                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="d-flex upgrade-line align-items-center mb-2">
                <hr>
                <h6 class="mb-0"><?php echo e(__('OR')); ?></h6>
                <hr>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="<?php echo e(route('module.buy', Crypt::encrypt($user->id))); ?>"
                        class="btn btn-primary"><?php echo e(__('Usage Subscription')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\users\upgrade.blade.php ENDPATH**/ ?>