

<?php $__env->startSection('page-title'); ?>
    Publish Event: <?php echo e($event->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('churchly.events.index')); ?>">Events</a></li>
    <li class="breadcrumb-item active">Publish</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0">
    <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ti ti-megaphone"></i> Finalize & Publish Event</h5>
        <span class="badge bg-light text-success px-3 py-2">Ready to Publish</span>
    </div>

    <div class="card-body">
        <div class="alert alert-info border-start border-4 border-info shadow-sm">
            <strong><i class="ti ti-info-circle"></i> Publishing Tip:</strong>
            When published, all program leaders, lead, co-lead, and creator will be notified.
            You can also add <strong>extra members</strong> and <strong>WhatsApp groups</strong> to receive the same message.
        </div>

        <!-- Event Summary -->
        <div class="mb-4">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-calendar-event"></i> Event Summary
            </h6>
            <p><strong>Title:</strong> <?php echo e($event->title); ?></p>
            <p><strong>Type:</strong> <?php echo e(ucfirst($event->event_type)); ?></p>
            <p><strong>Venue:</strong> <?php echo e($event->venue ?? 'TBA'); ?></p>
            <p><strong>Start:</strong> <?php echo e($event->start_time ? date('d M Y h:i A', strtotime($event->start_time)) : 'Not set'); ?></p>
        </div>

        <form method="POST" action="<?php echo e(route('churchly.events.publishAction', $event->id)); ?>">
            <?php echo csrf_field(); ?>

            <div class="row">
                <!-- ✅ Searchable Members -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="ti ti-user"></i> Notify Additional Members
                    </label>
                    <select name="additional_members[]" class="form-control searchable-select" multiple>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <small class="text-muted">Type a name to search quickly. Hold Ctrl/Cmd to select multiple.</small>
                </div>

                <!-- ✅ Searchable WhatsApp Groups -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="ti ti-brand-whatsapp"></i> Notify WhatsApp Groups
                    </label>
                    <select name="groups[]" class="form-control searchable-select" multiple>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($group->id); ?>">
                                <?php echo e($group->name); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->branches->count()): ?>
                                    (<?php echo e($group->branches->pluck('name')->implode(', ')); ?>)
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <small class="text-muted">Search or select multiple groups to notify.</small>
                </div>
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="notify_all" value="1" id="notify_all">
                <label class="form-check-label" for="notify_all">
                    Notify all church members.
                </label>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-4">
                    <i class="ti ti-send"></i> Publish & Send Notifications
                </button>
                <a href="<?php echo e(route('churchly.events.index')); ?>" class="btn btn-outline-secondary px-4">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- ✅ Select2 (CDN version, no extra setup needed) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.searchable-select').select2({
        placeholder: 'Search and select...',
        width: '100%',
        allowClear: true,
        closeOnSelect: false
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\events\publish.blade.php ENDPATH**/ ?>