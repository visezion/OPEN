

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm p-4 text-center">
    <h4><?php echo e($attendanceEvent->event->title); ?></h4>
    <p><?php echo e(__('Welcome! Please confirm your presence.')); ?></p>

    <form action="<?php echo e(route('churchly.attendance.onlineCheckIn', $attendanceEvent->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-success btn-lg">✅ I Am Here</button>
    </form>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->online_platform === 'zoom'): ?>
        <p class="mt-3">Join Zoom Meeting: <a href="<?php echo e($attendanceEvent->meeting_link); ?>" target="_blank">Click Here</a></p>
    <?php elseif($attendanceEvent->online_platform === 'youtube'): ?>
        <iframe width="560" height="315" 
            src="<?php echo e($attendanceEvent->meeting_link); ?>" 
            frameborder="0" allowfullscreen></iframe>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\check_in.blade.php ENDPATH**/ ?>