<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo e($event->title); ?> - Event Report</title>
    <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/event-report.css')); ?>">
</head>
<body>
<?php
    $eventStart = $event->start_time ? \Carbon\Carbon::parse($event->start_time) : null;
    $eventEnd = $event->end_time ? \Carbon\Carbon::parse($event->end_time) : null;
    $cursor = $eventStart ? $eventStart->copy() : null;
?>

<h1><?php echo e($event->title); ?></h1>

<div class="meta">
    <p><strong>Type:</strong> <?php echo e(ucfirst((string) $event->event_type)); ?></p>
    <p><strong>Status:</strong> <?php echo e(ucfirst((string) $event->status)); ?></p>
    <p><strong>Venue:</strong> <?php echo e($event->venue ?: '-'); ?></p>
    <p><strong>Date:</strong> <?php echo e($eventStart ? $eventStart->format('d M Y') : '-'); ?></p>
    <p><strong>Start Time:</strong> <?php echo e($eventStart ? $eventStart->format('g:i A') : '-'); ?></p>
    <p><strong>End Time:</strong> <?php echo e($eventEnd ? $eventEnd->format('g:i A') : '-'); ?></p>
    <p><strong>Recurrence:</strong> <?php echo e(ucfirst((string) ($event->recurrence ?: 'none'))); ?></p>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($event->description)): ?>
        <p><strong>Description:</strong> <?php echo e($event->description); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<h2>Program Schedule</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Program Item</th>
            <th>Duration</th>
            <th>Time Range</th>
            <th>Leader</th>
        </tr>
    </thead>
    <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $event->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $durationMinutes = max(0, (int) ($p->duration ?? 0));
                $timeRange = '-';

                if ($cursor) {
                    $slotStart = $cursor->copy();
                    $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

                    if ($eventEnd && $slotEnd->gt($eventEnd)) {
                        $slotEnd = $eventEnd->copy();
                    }

                    $timeRange = $slotStart->format('g:i A') . ' - ' . $slotEnd->format('g:i A');
                    $cursor = $slotEnd->copy();
                }
            ?>
            <tr>
                <td><?php echo e($i + 1); ?></td>
                <td><?php echo e($p->program_item); ?></td>
                <td><?php echo e($durationMinutes); ?> min</td>
                <td><?php echo e($timeRange); ?></td>
                <td><?php echo e($p->leader->name ?? '-'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="event-report-empty-cell">No program items added.</td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </tbody>
</table>

<footer>
    Generated on <?php echo e(now()->format('d M Y, g:i A')); ?>

</footer>

<div class="brand">
    Copyright <?php echo e(now()->format('Y')); ?> ChurchMeet Event System - Automated Report
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\pdf.blade.php ENDPATH**/ ?>