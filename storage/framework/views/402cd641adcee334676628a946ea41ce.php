

<?php $__env->startSection('page-title', __('Member Attendance Report')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4 shadow-sm">
    <h5><?php echo e($member->name); ?> - <?php echo e(__('Attendance Report')); ?></h5>
    <p><strong>Total Events Attended:</strong> <?php echo e($member->attendanceRecords->count()); ?></p>
    <p><strong>Attendance %:</strong> 
        <?php echo e(round(($member->attendanceRecords->where('status','present')->count() / max(1,$member->attendanceRecords->count())) * 100, 1)); ?>%
    </p>
    <p><strong>Longest Streak:</strong> <?php echo e($member->attendanceRecords->max('streak_count') ?? 0); ?></p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th><?php echo e(__('Event')); ?></th>
                <th><?php echo e(__('Date')); ?></th>
                <th><?php echo e(__('Status')); ?></th>
                <th><?php echo e(__('Device')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $member->attendanceRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($record->attendanceEvent->event->title); ?></td>
                <td><?php echo e($record->attendanceEvent->event->date); ?></td>
                <td><?php echo e(ucfirst($record->status)); ?></td>
                <td><?php echo e(strtoupper($record->device_used)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\reports\member_report.blade.php ENDPATH**/ ?>