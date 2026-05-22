<?php $__env->startSection('page-title', __('Attendance Leaderboard')); ?>
<?php $__env->startSection('page-breadcrumb', __('ChurchMeet,Attendance Leaderboard')); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $topEntry = $leaderboard->first();
    $topPoints = $topEntry?->member?->attendanceRecords->sum('xp_points') ?? 0;
    $bestStreak = $leaderboard->max('streak_longest') ?? 0;
?>

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-trophy"></i><?php echo e(__('ChurchMeet Leaderboard')); ?></span>
            <h2 class="churchmeet-title"><?php echo e(__('Attendance Champions for :month', ['month' => date('F Y')])); ?></h2>
            <p class="churchmeet-copy mb-0"><?php echo e(__('Celebrate consistency, surface top engagement, and keep the attendance experience visually aligned with the rest of ChurchMeet.')); ?></p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Ranked Members')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($leaderboard->count()); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Members currently visible in this leaderboard.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Top XP')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($topPoints); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Highest total experience points earned so far.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Best Streak')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($bestStreak); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Longest attendance streak recorded on the board.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Current Leader')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e(\Illuminate\Support\Str::limit(optional(optional($topEntry)->member)->name ?? __('N/A'), 14)); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Member currently sitting at the top of the rankings.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="churchmeet-section">
        <div class="churchmeet-section-head">
            <h5><?php echo e(__('Leaderboard Table')); ?></h5>
            <p><?php echo e(__('A consistent branded view of attendance performance, points, and streaks across the month.')); ?></p>
        </div>
        <div class="table-responsive">
            <table class="table churchmeet-table align-middle mb-0">
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $leaderboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rank => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $xpPoints = $entry->member->attendanceRecords->sum('xp_points');
                        ?>
                        <tr>
                            <td><span class="churchmeet-badge <?php echo e($rank === 0 ? 'success' : ($rank < 3 ? 'warning' : '')); ?>">#<?php echo e($rank + 1); ?></span></td>
                            <td class="fw-semibold"><?php echo e($entry->member->name ?? __('Unknown')); ?></td>
                            <td><?php echo e($xpPoints); ?></td>
                            <td><?php echo e($entry->attendance_count); ?></td>
                            <td><?php echo e($entry->streak_longest); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4"><?php echo e(__('No leaderboard data is available yet.')); ?></td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\leaderboard.blade.php ENDPATH**/ ?>