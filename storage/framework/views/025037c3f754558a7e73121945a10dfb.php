<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo e($event->title); ?> - Event Report</title>
    <style>
        body {
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #2c3e50;
            background: #fff;
        }

        h1, h2 {
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 20px;
            border-bottom: 2px solid #0e3964;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 25px;
            font-size: 16px;
            border-left: 4px solid #0e3964;
            padding-left: 8px;
            color: #0e3964;
        }

        .meta {
            background: #f9fafb;
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .meta p {
            margin: 4px 0;
            line-height: 1.4;
        }

        .meta strong {
            width: 110px;
            display: inline-block;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            border: 1px solid #ddd;
        }

        th {
            background: #0e3964;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            padding: 8px;
            border: 1px solid #0e3964;
        }

        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) td {
            background: #f8f9fa;
        }

        footer {
            text-align: right;
            font-size: 11px;
            color: #777;
            margin-top: 25px;
            border-top: 1px dashed #ccc;
            padding-top: 6px;
        }

        .brand {
            font-size: 11px;
            color: #888;
            text-align: center;
            margin-top: 20px;
        }
    </style>
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
                <td colspan="5" style="text-align: center; color: #777;">No program items added.</td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </tbody>
</table>

<footer>
    Generated on <?php echo e(now()->format('d M Y, g:i A')); ?>

</footer>

<div class="brand">
    Copyright <?php echo e(now()->format('Y')); ?> Churchly Event System - Automated Report
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\events\pdf.blade.php ENDPATH**/ ?>