

<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title', $attendanceEvent->event->title . ' - ' . __('Attendance')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.attendance_events.index')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-eye"></i> <?php echo e(__('View All Attendance Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="col-md-12">
    <div class="row">
        
        <?php
            $methods = is_array($attendanceEvent->enabled_methods)
                ? $attendanceEvent->enabled_methods
                : (json_decode($attendanceEvent->enabled_methods ?? '[]', true) ?? []);
      
            $hasManual = in_array('manual', $methods);
            $hasQr = in_array('qr', $methods);
            $meetingDurationMinutes = null;
            if (!empty($attendanceEvent->event?->start_time) && !empty($attendanceEvent->event?->end_time)) {
                $meetingDurationMinutes = max(
                    0,
                    \Carbon\Carbon::parse($attendanceEvent->event->start_time)->diffInMinutes(
                        \Carbon\Carbon::parse($attendanceEvent->event->end_time),
                        false
                    )
                );
                if ($meetingDurationMinutes === 0) {
                    $meetingDurationMinutes = null;
                }
            }
        ?>

        
       

        <div class="<?php if($hasManual && $hasQr): ?> col-md-4 <?php elseif($hasManual || $hasQr): ?>  col-md-8 <?php else: ?> col-md-12 <?php endif; ?>">
            <div class="card shadow-sm p-4 mb-4">
                <h5 class="fw-bold"><?php echo e($attendanceEvent->event->title); ?></h5>
                <p class="text-muted"><?php echo e($attendanceEvent->event->description); ?></p>

                <div class="mb-3">
                    <strong><?php echo e(__('Date:')); ?></strong> <?php echo e($attendanceEvent->event->date); ?> <br>
                    <strong><?php echo e(__('Mode:')); ?></strong> <?php echo e(ucfirst($attendanceEvent->mode)); ?> <br>
                    <strong><?php echo e(__('Methods Enabled:')); ?></strong> <?php echo e(implode(', ', $methods)); ?>

                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->mode !== 'onsite'): ?>
                    <div class="mb-3">
                        <strong><?php echo e(__('Online Platform:')); ?></strong> <?php echo e(ucfirst($attendanceEvent->online_platform ?? '-')); ?> <br>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->meeting_link): ?>
                            <a href="<?php echo e($attendanceEvent->meeting_link); ?>" 
                               target="_blank" 
                               class="btn btn-sm btn-primary mt-2">
                                <?php echo e(__('Join Online Event')); ?>

                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array('manual', $methods)): ?>
        <div class="col-md-4">
            <div class="card p-3 mb-4 shadow-sm">
                <h6 class="fw-bold"><?php echo e(__('Manual Attendance Marking')); ?></h6>
                <p class="text-muted small mb-3">
                    <?php echo e(__('Search for a member by name, phone number, or member ID. 
                    Select the correct person, then click Ã¢â‚¬Å“Mark PresentÃ¢â‚¬Â to confirm attendance.')); ?>

                </p>

                <form action="<?php echo e(route('churchmeet.attendance.manualCheckIn', $attendanceEvent->id)); ?>" 
                      method="POST" class="row g-3 mt-4">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-7">
                        <select id="member-search" name="member_id" class="form-control" required></select>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-check"></i> <?php echo e(__('Mark Present')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array('qr', $methods)): ?>
        <div class="col-md-4">
            <div class="card p-3 mb-4 shadow-sm">
                <h6 class="fw-bold"><?php echo e(__('QR Code Attendance Scanner')); ?></h6>
                <p class="text-muted small mb-3">
                    <?php echo e(__('Scan a memberÃ¢â‚¬â„¢s unique QR code to mark attendance instantly. 
                    Works online and offline, syncing automatically once reconnected.')); ?>

                </p>

                <div class="text-center mt-5">
                    <a href="<?php echo e(route('churchmeet.attendance_events.scan', $attendanceEvent->id)); ?>"
                       class="btn btn-success d-flex align-items-center justify-content-center gap-2 shadow-sm w-100"
                       title="<?php echo e(__('Open QR Scanner')); ?>">
                        <i class="ti ti-qrcode fs-4"></i>
                        <span class="fw-semibold"><?php echo e(__('Launch QR Scanner')); ?></span>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="card p-3 mb-4 shadow-sm">
        <h6 class="fw-bold mt-2"><?php echo e(__('Attendance Records')); ?></h6>
        <p class="text-muted small mb-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($meetingDurationMinutes): ?>
                <?php echo e(__('Scheduled meeting duration: :minutes min', ['minutes' => $meetingDurationMinutes])); ?>

            <?php else: ?>
                <?php echo e(__('Meeting duration is not set on this event yet.')); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>

        <table class="table table-bordered align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th><?php echo e(__('Member')); ?></th>
                    <th><?php echo e(__('Status')); ?></th>
                    <th><?php echo e(__('Check-In Time')); ?></th>
                    <th><?php echo e(__('Check-Out Time')); ?></th>
                    <th><?php echo e(__('Joined Duration')); ?></th>
                    <th><?php echo e(__('vs Meeting')); ?></th>
                    <th><?php echo e(__('Device Used')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $attendanceEvent->records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $checkIn = $record->check_in_time ? \Carbon\Carbon::parse($record->check_in_time) : null;
                        $checkOut = $record->check_out_time ? \Carbon\Carbon::parse($record->check_out_time) : null;
                        $effectiveEnd = $checkOut ?: ($checkIn ? now() : null);
                        $joinedMinutes = ($checkIn && $effectiveEnd) ? max(0, $checkIn->diffInMinutes($effectiveEnd)) : null;
                        $joinedLabel = is_null($joinedMinutes) ? '-' : ($joinedMinutes . ' ' . __('min') . ($checkOut ? '' : ' (' . __('live') . ')'));
                        $compareLabel = '-';
                        if (!is_null($joinedMinutes) && !empty($meetingDurationMinutes)) {
                            $comparePercent = round(min(100, ($joinedMinutes / $meetingDurationMinutes) * 100), 1);
                            $compareLabel = $comparePercent . '%';
                        }
                    ?>
                    <tr>
                        <td><?php echo e($record->member->name ?? __('Visitor')); ?></td>
                        <td>
                            <span class="badge bg-success"><?php echo e(ucfirst($record->status)); ?></span>
                        </td>
                        <td><?php echo e($record->check_in_time ?? '-'); ?></td>
                        <td><?php echo e($record->check_out_time ?? '-'); ?></td>
                        <td><?php echo e($joinedLabel); ?></td>
                        <td><?php echo e($compareLabel); ?></td>
                        <td><?php echo e(strtoupper($record->device_used)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            <?php echo e(__('No attendance records available yet.')); ?>

                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    $('#member-search').select2({
        placeholder: "<?php echo e(__('Search Member by Name, Phone, or ID')); ?>",
        minimumInputLength: 1,
        ajax: {
            url: "<?php echo e(route('churchmeet.attendance.searchMember')); ?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (member) {
                        return { 
                            id: member.id, 
                            text: member.name + ' (' + member.phone + ' | ID:' + member.id + ')' 
                        };
                    })
                };
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\attendance_events\show.blade.php ENDPATH**/ ?>