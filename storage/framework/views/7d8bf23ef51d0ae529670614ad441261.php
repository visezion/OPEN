

<?php $__env->startSection('page-title', __('Attendance Leaderboard')); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm p-4">
    <h5><?php echo e(__('Leaderboard for')); ?> <?php echo e(date('F Y')); ?></h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo e(__('Rank')); ?></th>
                <th><?php echo e(__('Member')); ?></th>
                <th><?php echo e(__('XP Points')); ?></th>
                <th><?php echo e(__('Attendance Count')); ?></th>
                <th><?php echo e(__('Longest Streak')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $leaderboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rank => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($rank+1); ?></td>
                <td><?php echo e($entry->member->name ?? 'Unknown'); ?></td>
                <td><?php echo e($entry->member->attendanceRecords->sum('xp_points')); ?></td>
                <td><?php echo e($entry->attendance_count); ?></td>
                <td><?php echo e($entry->streak_longest); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\leaderboard.blade.php ENDPATH**/ ?>