<?php $__env->startSection('page-title', __('Zoom Integration')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.church')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Zoom Integration')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><?php echo e(__('Server-to-Server OAuth')); ?></h6>
        <div>
          <a href="<?php echo e(route('churchly.zoom.test')); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Test Connection')); ?></a>
          <a href="<?php echo e(route('churchly.zoom.sync')); ?>" class="btn btn-sm btn-outline-primary"><?php echo e(__('Sync Now')); ?></a>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php echo e(route('churchly.zoom.save')); ?>"><?php echo csrf_field(); ?>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Account ID')); ?></label>
            <input type="text" name="account_id" value="<?php echo e(old('account_id',$setting->account_id)); ?>" class="form-control" placeholder="zoom account id">
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Client ID')); ?></label>
            <input type="text" name="client_id" value="<?php echo e(old('client_id',$setting->client_id)); ?>" class="form-control" placeholder="client id">
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Client Secret')); ?></label>
            <input type="text" name="client_secret" value="<?php echo e(old('client_secret',$setting->client_secret)); ?>" class="form-control" placeholder="client secret">
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><?php echo e(__('Sync Interval')); ?></label>
              <select name="interval_minutes" class="form-select">
                <?php $__currentLoopData = [5,10,15,30,60,120,360,720,1440]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($m); ?>" <?php echo e(($setting->interval_minutes ?? 15)==$m ? 'selected':''); ?>><?php echo e($m<60?$m.' min':($m%1440==0?'Daily':($m/60).' hr')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-6 align-self-end">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="active" value="1" <?php echo e($setting->active?'checked':''); ?>>
                <label class="form-check-label"><?php echo e(__('Enable Auto Sync')); ?></label>
              </div>
            </div>
          </div>
          <div class="text-end mt-3"><button class="btn btn-primary"><?php echo e(__('Save Settings')); ?></button></div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h6 class="mb-0"><?php echo e(__('Recent Events with Meeting ID')); ?></h6></div>
      <div class="card-body">
        <ul class="list-group">
          <?php $__empty_1 = true; $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">#<?php echo e($ev->id); ?> — <?php echo e($ev->event->title ?? 'Event'); ?></div>
                <small class="text-muted">Meeting ID: <?php echo e($ev->meeting_id ?? '-'); ?></small>
              </div>
              <a href="<?php echo e(route('churchly.attendance_events.edit', $ev->id)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Open')); ?></a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="list-group-item text-muted"><?php echo e(__('No recent events found.')); ?></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header"><h6 class="mb-0"><?php echo e(__('Recent Participants')); ?></h6></div>
      <div class="card-body">
        <div class="list-group">
          <?php $__empty_1 = true; $__currentLoopData = $recentParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="list-group-item">
              <div class="fw-semibold"><?php echo e($p->user_name); ?> <small class="text-muted"><?php echo e($p->user_email); ?></small></div>
              <small class="text-muted"><?php echo e(__('Join')); ?>: <?php echo e(optional($p->join_time)->toDateTimeString()); ?> • <?php echo e(__('Duration')); ?>: <?php echo e($p->duration); ?>s</small>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-muted"><?php echo e(__('No participants synced yet.')); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\integrations\zoom.blade.php ENDPATH**/ ?>