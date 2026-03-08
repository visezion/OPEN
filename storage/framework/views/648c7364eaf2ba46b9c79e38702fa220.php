<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reset Password')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('language-bar'); ?>
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href  ="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> <?php echo e(Str::upper($lang)); ?>

                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/forgot-password', $key)); ?>"
                        class="dropdown-item <?php if($lang == $key): ?> text-primary <?php endif; ?>">
                        <span><?php echo e(Str::ucfirst($language)); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </li>
    </div>
<?php $__env->stopSection(); ?>
<?php
    $admin_settings = getAdminAllSetting();
?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="">
                <h2 class="mb-3 f-w-600"><?php echo e(__('Forgot Password')); ?></h2>
                <?php if(session('status')): ?>
                    <div class="alert alert-primary">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                <p class="text-xs text-muted"><?php echo e(__('We will send a link to reset your password')); ?></p>
            </div>
            <form method="POST" action="<?php echo e(route('password.email')); ?>" id="form_data" class="needs-validation" novalidate="">
                <?php echo csrf_field(); ?>
                <div class="">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-email text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php echo $__env->yieldPushContent('recaptcha_field'); ?>

                    <div class="d-grid">
                        <button class="btn btn-primary btn-submit btn-block mt-2"><?php echo e(__('Send Password Reset Link')); ?>

                        </button>
                    </div>
                    <p class="my-4 mb-0 text-center"><?php echo e(__('Or')); ?>

                        <a href="<?php echo e(route('login', $lang)); ?>"
                            class="my-4 text-primary"><?php echo e(__('Login')); ?></a><?php echo e(__(' With')); ?>

                    </p>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>