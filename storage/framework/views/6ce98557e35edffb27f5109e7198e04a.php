<?php $__env->startSection('page-title', __('YouTube Sync')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.church')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('YouTube Sync')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h5 class="mb-0"><?php echo e(__('Settings')); ?></h5></div>
      <div class="card-body">
        <form method="POST" action="<?php echo e(route('churchly.youtube.save')); ?>"><?php echo csrf_field(); ?>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Channel ID')); ?></label>
            <input type="text" class="form-control" name="channel_id" value="<?php echo e(old('channel_id',$setting->channel_id)); ?>" placeholder="UCxxxxxxxxxxx">
            <small class="text-muted"><?php echo e(__('You can also use Playlist ID instead.')); ?></small>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo e(__('Playlist ID (optional)')); ?></label>
            <input type="text" class="form-control" name="playlist_id" value="<?php echo e(old('playlist_id',$setting->playlist_id)); ?>" placeholder="PLxxxxxxxxxxx">
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><?php echo e(__('Mode')); ?></label>
              <select class="form-select" name="mode">
                <option value="all" <?php echo e(($setting->mode ?? 'all')==='all'?'selected':''); ?>><?php echo e(__('All videos')); ?></option>
                <option value="live" <?php echo e(($setting->mode ?? 'all')==='live'?'selected':''); ?>><?php echo e(__('Live videos only')); ?></option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label"><?php echo e(__('Sync Interval')); ?></label>
              <select class="form-select" name="interval_minutes">
                <?php $__currentLoopData = [5,15,30,60,120,360,720,1440]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($m); ?>" <?php echo e(($setting->interval_minutes ?? 60)==$m?'selected':''); ?>><?php echo e($m<60 ? $m.' min' : ($m%1440==0 ? 'Daily' : ($m/60).' hr')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="mb-3 mt-3">
            <label class="form-label"><?php echo e(__('YouTube API Key (optional)')); ?></label>
            <input type="text" class="form-control" name="api_key" value="<?php echo e(old('api_key',$setting->api_key)); ?>" placeholder="AIza...">
            <small class="text-muted"><?php echo e(__('If empty, falls back to services.youtube.key')); ?></small>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="active" value="1" <?php echo e($setting->active ? 'checked' : ''); ?>>
            <label class="form-check-label"><?php echo e(__('Enable Auto Sync')); ?></label>
          </div>
          <button class="btn btn-primary"><?php echo e(__('Save Settings')); ?></button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?php echo e(__('Recent Videos')); ?></h5>
        <a href="<?php echo e(url('api/v1/churchly/youtube/videos')); ?>" target="_blank" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Open API')); ?></a>
      </div>
      <div class="card-body">
        <div class="list-group">
          <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="https://www.youtube.com/watch?v=<?php echo e($v->youtube_video_id); ?>" class="list-group-item list-group-item-action d-flex" target="_blank">
              <img src="<?php echo e($v->thumbnail_url); ?>" class="me-2" alt="thumb" style="width:72px;height:40px;object-fit:cover;">
              <div>
                <div class="fw-semibold"><?php echo e($v->title); ?></div>
                <small class="text-muted"><?php echo e(optional($v->published_at)->diffForHumans()); ?> • <?php echo e($v->live_broadcast_content ?: 'video'); ?></small>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-muted"><?php echo e(__('No videos synced yet.')); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\integrations\youtube.blade.php ENDPATH**/ ?>