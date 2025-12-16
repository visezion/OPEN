<?php $__env->startSection('title', __('Request Food Assistance')); ?>
<?php $__env->startSection('content'); ?>
    <div class="note mb-3">
        <h2><?php echo e(__('Request Food Assistance')); ?></h2>
        <p class="text-muted"><?php echo e(__('Share your details, choose pickup or delivery, and our volunteers will coordinate within 24 hours.')); ?></p>
    </div>
    <form id="foodForm" action="<?php echo e(route('foodbank.public.request.submit', $token)); ?>" method="post">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <div class="grid">
            <div class="field">
                <label><?php echo e(__('Full name')); ?></label>
                <input type="text" name="requester_name" required>
            </div>
            <div class="field">
                <label><?php echo e(__('Phone')); ?></label>
                <input type="text" name="phone">
            </div>
            <div class="field">
                <label><?php echo e(__('Email')); ?></label>
                <input type="email" name="email">
            </div>
            <div class="field">
                <label><?php echo e(__('Family size')); ?></label>
                <input type="number" name="family_size" min="1" value="1" required>
            </div>
            <div class="field">
                <label><?php echo e(__('Children at home')); ?></label>
                <input type="number" name="children_count" min="0" value="0">
            </div>
            <div class="field">
                <label><?php echo e(__('Delivery option')); ?></label>
                <select name="delivery_preference" id="deliveryMode">
                    <option value="pickup"><?php echo e(__('Pickup')); ?></option>
                    <option value="delivery"><?php echo e(__('Delivery')); ?></option>
                </select>
            </div>
            <div class="field" id="pickupHint">
                <label><?php echo e(__('Pickup address')); ?></label>
                <input type="text" value="Community aid centre, 14 Hope Street" readonly>
            </div>
            <div class="field d-none" id="deliveryAddress">
                <label><?php echo e(__('Delivery address')); ?></label>
                <input type="text" name="delivery_address">
            </div>
            <div class="field">
                <label><?php echo e(__('Describe your needs')); ?></label>
                <textarea name="needs_description" rows="3"></textarea>
            </div>
            <div class="field">
                <label><?php echo e(__('Notify me via')); ?></label>
                <div class="d-flex gap-2">
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="email" checked> <?php echo e(__('Email')); ?></label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="whatsapp"> <?php echo e(__('WhatsApp')); ?></label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="sms"> <?php echo e(__('SMS')); ?></label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn-wide" type="submit"><?php echo e(__('Submit request')); ?></button>
        </div>
    </form>
    <div class="summary-grid" id="summary">
        <div><span><?php echo e(__('Family size')); ?>:</span> <span id="summary-family">1</span></div>
        <div><span><?php echo e(__('Children')); ?>:</span> <span id="summary-children">0</span></div>
        <div><span><?php echo e(__('Delivery')); ?>:</span> <span id="summary-delivery"><?php echo e(__('Pickup')); ?></span></div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deliveryMode = document.getElementById('deliveryMode');
            const deliveryAddress = document.getElementById('deliveryAddress');
            const pickupHint = document.getElementById('pickupHint');
            const summaryFamily = document.getElementById('summary-family');
            const summaryChildren = document.getElementById('summary-children');
            const summaryDelivery = document.getElementById('summary-delivery');

            function toggleDelivery() {
                const isDelivery = deliveryMode.value === 'delivery';
                deliveryAddress.classList.toggle('d-none', !isDelivery);
                pickupHint.classList.toggle('d-none', isDelivery);
                summaryDelivery.textContent = isDelivery ? '<?php echo e(__('Delivery')); ?>' : '<?php echo e(__('Pickup')); ?>';
            }
            deliveryMode.addEventListener('change', toggleDelivery);
            toggleDelivery();

            const familyInput = document.querySelector('input[name="family_size"]');
            const childrenInput = document.querySelector('input[name="children_count"]');
            familyInput.addEventListener('input', () => summaryFamily.textContent = familyInput.value || '1');
            childrenInput.addEventListener('input', () => summaryChildren.textContent = childrenInput.value || '0');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('foodbank::public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('foodbank::public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Providers/../Resources/views/public/request.blade.php ENDPATH**/ ?>