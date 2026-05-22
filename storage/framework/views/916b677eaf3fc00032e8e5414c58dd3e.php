

<?php $__env->startPush('head'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow-sm">
        <div style="line-height: 2.5 !important;" class="card-body church-timer-guide">

            <div class="text-center mb-4">
                <h1 class="fw-bold" style="font-size: 1.8rem;">📖 <?php echo e(__('Church Program Timer')); ?></h1>
                <p class="text-muted mb-0"><?php echo e(__('User-friendly guide to managing your live church programs efficiently.')); ?></p>
            </div>

            <hr class="my-4">

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🚀 <?php echo e(__('Overview')); ?></h4>
                <p><?php echo e(__('The Church Program Timer helps churches maintain service order with an interactive countdown system ensuring timely transitions between segments. It provides:')); ?></p>
                <ul class="list-unstyled ms-3">
                    <li>⏳ <strong><?php echo e(__('Live circular countdown timer')); ?></strong></li>
                    <li>⚠️ <strong><?php echo e(__('TIME UP!!! alerts at 45 seconds remaining')); ?></strong></li>
                    <li>🛎️ <strong><?php echo e(__('“KINDLY EXIT THE STAGE !!!” reminders (optional)')); ?></strong></li>
                    <li>🎥 <strong><?php echo e(__('Monitor View for projection screens')); ?></strong></li>
                    <li>💾 <strong><?php echo e(__('Easy schedule save/load functionality')); ?></strong></li>
                    <li>⛓️ <strong><?php echo e(__('Auto-transition between program segments')); ?></strong></li>
                </ul>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🛠️ <?php echo e(__('Using the Timer')); ?></h4>
                <ol class="ms-3">
                    <li><strong><?php echo e(__('Load or Add Programs:')); ?></strong> <?php echo e(__('Use "Load Schedule" for predefined segments or "Add Program" for custom entries.')); ?></li>
                    <li><strong><?php echo e(__('Edit Details:')); ?></strong> <?php echo e(__('Set the name, time, duration, and optionally enable "Exit Stage" reminders for each program.')); ?></li>
                    <li><strong><?php echo e(__('Start Countdown:')); ?></strong> <?php echo e(__('Press ▶️ next to a program to begin its timer.')); ?></li>
                    <li><strong><?php echo e(__('Monitor View:')); ?></strong> <?php echo e(__('Click "Open Monitor View" for projection on stage screens.')); ?></li>
                    <li><strong><?php echo e(__('Save/Load:')); ?></strong> <?php echo e(__('Save frequently used schedules for quick loading.')); ?></li>
                    <li><strong><?php echo e(__('Auto-Start:')); ?></strong> <?php echo e(__('Enable for automatic transitions between programs.')); ?></li>
                </ol>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">💡 <?php echo e(__('Features')); ?></h4>
                <div class="row">
                    <div class="col-md-6 mb-2"><span class="badge bg-success">LIVE</span> <?php echo e(__('Circular visual timer ring for presenters and audience.')); ?></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-warning text-dark">ALERT</span> <?php echo e(__('“TIME UP!!!” alert at 45 seconds remaining.')); ?></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-info">OPTIONAL</span> <?php echo e(__('“KINDLY EXIT THE STAGE !!!” reminders for smooth transitions.')); ?></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-primary">MONITOR</span> <?php echo e(__('Projection-friendly display for stage or overflow rooms.')); ?></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-secondary">AUTO</span> <?php echo e(__('Auto-start next program for seamless flow.')); ?></div>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🎯 <?php echo e(__('Best Practices')); ?></h4>
                <ul class="ms-3">
                    <li>✅ <?php echo e(__('Test your schedule before live use to align with your service plan.')); ?></li>
                    <li>✅ <?php echo e(__('Use Monitor View for clear stage and audience visibility.')); ?></li>
                    <li>✅ <?php echo e(__('Save frequently used schedules for efficient preparation.')); ?></li>
                    <li>✅ <?php echo e(__('Enable Auto-Start for stress-free transitions.')); ?></li>
                </ul>
            </div>
         
                <a href="<?php echo e(route('timer.church')); ?>" class="btn btn-dark">
                    You have invested your time in leaning how to use the timer NOW LET GET STARTED</b>
                </a>  <br>  <br>
        
            <div class="mb-5">
                <h4 class="fw-semibold mb-3">📞 <?php echo e(__('Support & Customization')); ?></h4>
                <p><?php echo e(__('Need enhancements like sound alerts, color flash warnings, or remote control features? Contact your system administrator or developer to customize the Church Program Timer for your workflow needs.')); ?></p>
            </div>
            
            <div class="text-center text-muted small">
                <?php echo e(__('Church Program Timer © 2025 | Helping your services flow with clarity and excellence.')); ?>

            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\doc.blade.php ENDPATH**/ ?>