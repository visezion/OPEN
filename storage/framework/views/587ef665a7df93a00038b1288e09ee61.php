

<?php $__env->startSection('page-title', __('Google Integration')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Google Integration')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
  <div class="card-body">
    <?php if(session('success')): ?>
      <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
      <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <h5><?php echo e(__('Workspace Google OAuth Credentials')); ?></h5>
    <form method="POST" action="<?php echo e(route('churchly.google.credentials.save')); ?>" class="mb-4">
      <?php echo csrf_field(); ?>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Client ID</label>
          <input type="text" name="client_id" class="form-control" value="<?php echo e(old('client_id', $cred->client_id ?? '')); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Client Secret</label>
          <input type="text" name="client_secret" class="form-control" value="<?php echo e(old('client_secret', $cred->client_secret ?? '')); ?>" required>
        </div>
        <div class="col-md-8 mb-3">
          <label class="form-label">Redirect URI</label>
          <input type="url" name="redirect_uri" class="form-control" value="<?php echo e(old('redirect_uri', $cred->redirect_uri ?? url('/api/v1/churchly/auth/google/callback'))); ?>" required>
          <small class="text-muted"><?php echo e(__('Set this in Google Cloud console. You can use the API callback above or a custom web callback.')); ?></small>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-end">
          <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" name="active" value="1" <?php echo e(($cred->active ?? true) ? 'checked' : ''); ?>>
            <label class="form-check-label"><?php echo e(__('Active')); ?></label>
          </div>
        </div>
      </div>
      <div class="text-end">
        <button class="btn btn-primary"><?php echo e(__('Save Credentials')); ?></button>
      </div>
    </form>

    <h6 class="mt-4"><?php echo e(__('Connect Your Google Account')); ?></h6>
    <p class="text-muted"><?php echo e(__('Connect to capture a refresh token to access Classroom (and later Drive/Calendar).')); ?></p>
    <a href="<?php echo e(route('churchly.google.connect')); ?>" class="btn btn-outline-primary">
      <i class="ti ti-brand-google"></i> <?php echo e(__('Connect Google')); ?>

    </a>

    <hr>
    <div class="small text-muted">
      <strong><?php echo e(__('Scopes currently requested')); ?>:</strong>
      <code>openid profile email classroom.courses.readonly classroom.rosters</code>
      <br>
      <?php echo e(__('When Drive/Calendar are enabled later, users will be prompted to re-authorize.')); ?>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\google\credentials.blade.php ENDPATH**/ ?>