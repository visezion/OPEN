<?php $isEdit = !empty($requestEntry); ?>



<?php $__env->startSection('page-title', $isEdit ? __('Edit request') : __('New request')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.requests.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Back to list')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form method="post" action="<?php echo e($isEdit ? route('foodbank.requests.update', $requestEntry) : route('foodbank.requests.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEdit): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Full name')); ?></label>
                        <input type="text" name="requester_name" value="<?php echo e(old('requester_name', $requestEntry->requester_name ?? '')); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Occupation')); ?></label>
                        <input type="text" name="occupation" value="<?php echo e(old('occupation', $requestEntry->occupation ?? '')); ?>" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Marital status')); ?></label>
                        <select name="marital_status" class="form-select" id="fb-marital">
                            <option value=""><?php echo e(__('None')); ?></option>
                            <option value="single" <?php echo e(old('marital_status', $requestEntry->marital_status ?? '') === 'single' ? 'selected' : ''); ?>><?php echo e(__('Single')); ?></option>
                            <option value="married" <?php echo e(old('marital_status', $requestEntry->marital_status ?? '') === 'married' ? 'selected' : ''); ?>><?php echo e(__('Married')); ?></option>
                            <option value="other" <?php echo e(old('marital_status', $requestEntry->marital_status ?? '') === 'other' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Family size')); ?></label>
                        <input type="number" name="family_size" min="1" value="<?php echo e(old('family_size', $requestEntry->family_size ?? 1)); ?>" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Children at home')); ?></label>
                        <input type="number" name="children_count" min="0" value="<?php echo e(old('children_count', $requestEntry->children_count ?? 0)); ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Phone')); ?></label>
                        <input type="text" name="phone" value="<?php echo e(old('phone', $requestEntry->phone ?? '')); ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Email')); ?></label>
                        <input type="email" name="email" value="<?php echo e(old('email', $requestEntry->email ?? '')); ?>" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Delivery option')); ?></label>
                        <select name="delivery_preference" class="form-select" id="fb-delivery">
                            <option value=""><?php echo e(__('Choose option')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $deliveryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('delivery_preference', $requestEntry->delivery_preference ?? '') === $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Pickup location')); ?></label>
                        <input type="text" name="pickup_location" value="<?php echo e(old('pickup_location', $requestEntry->pickup_location ?? '')); ?>" class="form-control">
                    </div>

                    <div id="delivery-fields" class="row g-3" style="display: none;">
                        <div class="col-md-12">
                            <label class="form-label"><?php echo e(__('Delivery address')); ?></label>
                            <textarea name="delivery_address" class="form-control" rows="2"><?php echo e(old('delivery_address', $requestEntry->delivery_address ?? '')); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('Map link')); ?></label>
                            <input type="url" name="delivery_map" value="<?php echo e(old('delivery_map', $requestEntry->delivery_map ?? '')); ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                            <input type="text" name="delivery_lat" value="<?php echo e(old('delivery_lat', $requestEntry->delivery_lat ?? '')); ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                            <input type="text" name="delivery_lng" value="<?php echo e(old('delivery_lng', $requestEntry->delivery_lng ?? '')); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label"><?php echo e(__('Describe your needs')); ?></label>
                        <textarea name="needs_description" rows="3" class="form-control"><?php echo e(old('needs_description', $requestEntry->needs_description ?? '')); ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                        <select name="status" class="form-select">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php echo e(old('status', $requestEntry->status ?? 'pending') === $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label"><?php echo e(__('Notification channels')); ?></label>
                        <div class="d-flex gap-3 flex-wrap">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['email' => 'Email', 'whatsapp' => 'WhatsApp', 'sms' => 'SMS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="notify_channels[]" value="<?php echo e($channel); ?>"
                                           <?php echo e(in_array($channel, old('notify_channels', $requestEntry->notify_channels ?? []), true) ? 'checked' : ''); ?>>
                                    <span class="form-check-label"><?php echo e(__($label)); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e($isEdit ? __('Update request') : __('Create request')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const deliverySelect = document.getElementById('fb-delivery');
                const deliveryFields = document.getElementById('delivery-fields');

                function toggleDelivery() {
                    deliveryFields.style.display = deliverySelect.value === 'delivery' ? 'flex' : 'none';
                }

                deliverySelect.addEventListener('change', toggleDelivery);
                toggleDelivery();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\requests\form.blade.php ENDPATH**/ ?>