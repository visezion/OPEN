

<?php $__env->startSection('page-title', __('Event Attendance Report')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4 shadow-sm">
    <h5><?php echo e($attendanceEvent->event->title); ?> - <?php echo e($attendanceEvent->event->date); ?></h5>

    <p><strong>Total Attendance:</strong> <?php echo e($attendanceEvent->records->count()); ?></p>
    <p><strong>Onsite:</strong> <?php echo e($attendanceEvent->records->whereIn('device_used',['manual','qr','kiosk','face_ai'])->count()); ?></p>
    <p><strong>Online:</strong> <?php echo e($attendanceEvent->records->whereIn('device_used',['online','zoom','youtube'])->count()); ?></p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th><?php echo e(__('Member')); ?></th>
                <th><?php echo e(__('Status')); ?></th>
                <th><?php echo e(__('Check-In')); ?></th>
                <th><?php echo e(__('Device')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $attendanceEvent->records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($record->member->name ?? 'Visitor'); ?></td>
                <td><?php echo e(ucfirst($record->status)); ?></td>
                <td><?php echo e($record->check_in_time); ?></td>
                <td><?php echo e(strtoupper($record->device_used)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\reports\event_report.blade.php ENDPATH**/ ?>