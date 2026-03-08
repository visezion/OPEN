<div class="action-btn">
    <a href="<?php echo e(route('notification-template.show', [$Notification->id, getActiveLanguage()])); ?>"
        class="mx-3 btn btn-sm align-items-center bg-warning"
        data-bs-toggle="tooltip" data-bs-placement="top"
        title="<?php echo e(__('Manage Your ' . $Notification->type  . ' Message')); ?>">
        <i class="ti ti-eye text-white"></i>
    </a>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\notification_templates\action.blade.php ENDPATH**/ ?>