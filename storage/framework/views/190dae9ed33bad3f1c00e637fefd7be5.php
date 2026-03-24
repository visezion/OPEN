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
        <div class="alert alert-info">
          <strong><?php echo e(__('Where to get each value')); ?>:</strong>
          <?php echo e(__('Use your Zoom Marketplace app credentials for OAuth and Meeting SDK values.')); ?>

          <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer" class="alert-link">
            <?php echo e(__('Open Zoom Marketplace Apps')); ?>

          </a>
        </div>
        <form method="POST" action="<?php echo e(route('churchly.zoom.save')); ?>"><?php echo csrf_field(); ?>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Account ID')); ?></label>
            <input type="text" name="account_id" value="<?php echo e(old('account_id',$setting->account_id)); ?>" class="form-control" placeholder="zoom account id">
            <small class="text-muted d-block mt-1">
              <?php echo e(__('From your Zoom Server-to-Server OAuth app credentials page.')); ?>

              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer"><?php echo e(__('Where to find Account ID')); ?></a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Client ID')); ?></label>
            <input type="text" name="client_id" value="<?php echo e(old('client_id',$setting->client_id)); ?>" class="form-control" placeholder="client id">
            <small class="text-muted d-block mt-1">
              <?php echo e(__('Use the Client ID from the same Server-to-Server OAuth app.')); ?>

              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer"><?php echo e(__('Where to find Client ID')); ?></a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Client Secret')); ?></label>
            <input type="text" name="client_secret" value="<?php echo e(old('client_secret',$setting->client_secret)); ?>" class="form-control" placeholder="client secret">
            <small class="text-muted d-block mt-1">
              <?php echo e(__('Use the Client Secret from your Server-to-Server OAuth app.')); ?>

              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer"><?php echo e(__('Where to find Client Secret')); ?></a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Host User ID or Email')); ?></label>
            <input type="text" name="host_user_id" value="<?php echo e(old('host_user_id',$setting->host_user_id)); ?>" class="form-control" placeholder="me or host user id">
            <small class="text-muted d-block mt-1"><?php echo e(__('Used when Churchly creates scheduled meetings through Zoom.')); ?></small>
            <small class="text-muted d-block">
              <?php echo e(__('Use a Zoom host email (recommended) or user ID from Zoom user management.')); ?>

              <a href="https://zoom.us/account/user" target="_blank" rel="noopener noreferrer"><?php echo e(__('Open Zoom User Management')); ?></a>
            </small>
          </div>
          <hr>
          <h6 class="mb-3"><?php echo e(__('Meeting SDK (for in-app join)')); ?></h6>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Meeting SDK Key')); ?></label>
            <input type="text" name="meeting_sdk_key" value="<?php echo e(old('meeting_sdk_key',$setting->meeting_sdk_key)); ?>" class="form-control" placeholder="sdk key">
            <small class="text-muted d-block mt-1">
              <?php echo e(__('From your Zoom Meeting SDK app credentials.')); ?>

              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer"><?php echo e(__('Where to find SDK Key')); ?></a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Meeting SDK Secret')); ?></label>
            <input type="text" name="meeting_sdk_secret" value="<?php echo e(old('meeting_sdk_secret',$setting->meeting_sdk_secret)); ?>" class="form-control" placeholder="sdk secret">
            <small class="text-muted d-block mt-1"><?php echo e(__('Required for users to join Zoom meetings inside OPEN instead of leaving the app.')); ?></small>
            <small class="text-muted d-block">
              <?php echo e(__('Use the secret from the same Zoom Meeting SDK app.')); ?>

              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer"><?php echo e(__('Where to find SDK Secret')); ?></a>
            </small>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><?php echo e(__('Sync Interval')); ?></label>
              <select name="interval_minutes" class="form-select">
                <?php $__currentLoopData = [5,10,15,30,60,120,360,720,1440]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($m); ?>" <?php echo e(($setting->interval_minutes ?? 15)==$m ? 'selected':''); ?>><?php echo e($m<60?$m.' min':($m%1440==0?'Daily':($m/60).' hr')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <small class="text-muted d-block mt-1"><?php echo e(__('How often Churchly pulls participant attendance from Zoom.')); ?></small>
            </div>
            <div class="col-md-6 align-self-end">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="active" value="1" <?php echo e($setting->active?'checked':''); ?>>
                <label class="form-check-label"><?php echo e(__('Enable Auto Sync')); ?></label>
              </div>
              <small class="text-muted d-block mt-1"><?php echo e(__('Turn on automatic background sync using the interval above.')); ?></small>
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/integrations/zoom.blade.php ENDPATH**/ ?>