<?php $__env->startSection('title', __('Donate to Food Bank')); ?>
<?php $__env->startSection('content'); ?>
    <div class="note mb-3">
        <h2><?php echo e(__('Donate food or essentials')); ?></h2>
        <p class="text-muted"><?php echo e(__('Tell us what you have available so we can match it with families in need.')); ?></p>
    </div>
    <form id="donationForm" action="<?php echo e(route('foodbank.public.donate.submit', $token)); ?>" method="post">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <div class="grid">
            <div class="field">
                <label><?php echo e(__('Item name')); ?></label>
                <input type="text" name="item_name" required>
            </div>
            <div class="field">
                <label><?php echo e(__('Category')); ?></label>
                <input type="text" name="category">
            </div>
            <div class="field">
                <label><?php echo e(__('Quantity')); ?></label>
                <input type="number" name="quantity" min="1" value="1" required>
            </div>
            <div class="field">
                <label><?php echo e(__('Unit')); ?></label>
                <input type="text" name="unit" value="pcs">
            </div>
            <div class="field">
                <label><?php echo e(__('Pickup location')); ?></label>
                <input type="text" name="pickup_location">
            </div>
            <div class="field">
                <label><?php echo e(__('Delivery details')); ?></label>
                <input type="text" name="delivery_details">
            </div>
            <div class="field full">
                <label><?php echo e(__('Tell us more')); ?></label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div class="field full">
                <label><?php echo e(__('Stay updated via')); ?></label>
                <div class="d-flex gap-2">
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="email" checked> <?php echo e(__('Email')); ?></label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="whatsapp"> <?php echo e(__('WhatsApp')); ?></label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="sms"> <?php echo e(__('SMS')); ?></label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn-wide" type="submit"><?php echo e(__('Submit donation')); ?></button>
        </div>
    </form>

    <div class="summary-grid mt-4">
        <div><span><?php echo e(__('Recent sharing')); ?>:</span> <span><?php echo e(__('Every donation is logged by admins and matched with requests.')); ?></span></div>
    </div>

    <?php if(!empty($adminStats)): ?>
        <div class="admin-panel">
            <h3><?php echo e(__('Workspace snapshot')); ?></h3>
            <div class="summary-grid">
                <div><span><?php echo e(__('Donors registered')); ?>:</span> <strong><?php echo e($adminStats['donors']); ?></strong></div>
                <div><span><?php echo e(__('Inventory items')); ?>:</span> <strong><?php echo e($adminStats['inventory_items']); ?></strong></div>
                <div><span><?php echo e(__('Pending requests')); ?>:</span> <strong><?php echo e($adminStats['pending_requests']); ?></strong></div>
            </div>
            <div class="field mt-3">
                <label><?php echo e(__('Share donation link')); ?></label>
                <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
                    <input id="admin-donate-link" type="text" readonly value="<?php echo e($adminStats['publicDonateLink']); ?>" style="flex:1; min-width:200px;">
                    <button class="btn-wide" id="copy-donate-link" type="button"><?php echo e(__('Copy link')); ?></button>
                </div>
            </div>
            <div class="field mt-3">
                <label><?php echo e(__('Share request link')); ?></label>
                <input type="text" readonly value="<?php echo e($adminStats['publicRequestLink']); ?>">
            </div>
            <div class="admin-links">
                <a class="btn-wide" href="<?php echo e(route('foodbank.donors.index')); ?>"><?php echo e(__('Manage donors')); ?></a>
                <a class="btn-wide" href="<?php echo e(route('foodbank.inventory.index')); ?>"><?php echo e(__('View inventory')); ?></a>
                <a class="btn-wide" href="<?php echo e(route('foodbank.requests.index')); ?>"><?php echo e(__('View requests')); ?></a>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const copyButton = document.getElementById('copy-donate-link');
            const copyTarget = document.getElementById('admin-donate-link');
            if (copyButton && copyTarget) {
                copyButton.addEventListener('click', () => {
                    copyTarget.select();
                    document.execCommand('copy');
                    const original = copyButton.textContent;
                    copyButton.textContent = '<?php echo e(__('Copied')); ?>';
                    setTimeout(() => {
                        copyButton.textContent = original;
                    }, 1500);
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('foodbank::public.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\public\donate.blade.php ENDPATH**/ ?>