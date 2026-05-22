<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reset Password')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('language-bar'); ?>
    <li class="lang-dropdown-only-desk dropdown dash-h-item drp-language">
        <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="drp-text"><?php echo e(Str::upper($lang)); ?></span>
        </a>
        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('password.request', $key)); ?>"
                    class="dropdown-item <?php if($lang == $key): ?> text-primary <?php endif; ?>">
                    <span><?php echo e(Str::ucfirst($language)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </li>
<?php $__env->stopSection(); ?>

<?php
    $admin_settings = getAdminAllSetting();
    $auth_brand = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : config('app.name', 'WorkDo');
?>

<?php $__env->startSection('content'); ?>
    <div class="dms-content-logo">
        <img src="<?php echo e(get_file(sidebar_logo())); ?><?php echo e('?' . time()); ?>" alt="<?php echo e(config('app.name', 'WorkDo')); ?>">
    </div>

    <div class="dms-faith-layout">
        <section class="dms-faith-hero" aria-hidden="true">
            <div class="dms-hero-gradient"></div>
            <div class="dms-scene-grid"></div>
            <div class="dms-hero-brand">
                <span><?php echo e(__('Admin Access')); ?></span>
            </div>
            <div class="dms-hero-map">
                <div class="dms-radar-ring ring-a"></div>
                <div class="dms-radar-ring ring-b"></div>
                <div class="dms-radar-ring ring-c"></div>

                <svg class="dms-flow-svg" viewBox="0 0 1000 1000" preserveAspectRatio="none" fill="none">
                    <path class="dms-flow-line" d="M500 480 L190 190" />
                    <path class="dms-flow-line" d="M500 480 L300 760" />
                    <path class="dms-flow-line" d="M500 480 L760 180" />
                    <path class="dms-flow-line" d="M500 480 L840 360" />
                    <path class="dms-flow-line" d="M500 480 L820 700" />
                    <path class="dms-flow-line" d="M500 480 L430 145" />
                    <path class="dms-flow-line" d="M500 480 L650 815" />
                    <path class="dms-flow-line" d="M500 480 L120 520" />
                </svg>

                <div class="dms-node node-a"><?php echo e(__('Prayer Requests')); ?></div>
                <div class="dms-node node-b"><?php echo e(__('Sunday Teams')); ?></div>
                <div class="dms-node node-c"><?php echo e(__('Outreach Tasks')); ?></div>
                <div class="dms-node node-d"><?php echo e(__('Policy Rules')); ?></div>
                <div class="dms-node node-e"><?php echo e(__('Service Reports')); ?></div>
                <div class="dms-node node-f"><?php echo e(__('Discipleship')); ?></div>
                <div class="dms-node dms-node-tag node-g">Testimonies</div>
                <div class="dms-node dms-node-tag node-h">Finances</div>

                <div class="dms-core">
                    <p><?php echo e(__('Control Plane')); ?></p>
                    <h3><?php echo e($auth_brand); ?></h3>
                    <small><?php echo e(__('In Christ Jesus')); ?></small>
                </div>
            </div>
            <div class="dms-hero-copy">
                <p class="dms-hero-label"><?php echo e(__('Faith Control Network')); ?></p>
                <h2><?php echo e(__('Secure account recovery with your registered email')); ?></h2>
                <p><?php echo e(__('Request a reset link and continue managing your ministry workspace safely.')); ?></p>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label"><?php echo e(__('Password Recovery')); ?></p>
                        <h2><?php echo e($auth_brand); ?></h2>
                        <p class="dms-card-copy"><?php echo e(__('Enter your account email to receive a secure reset link')); ?></p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">&#10013;</div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                    <div class="alert alert-success mb-3">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="dms-error"><?php echo e($errors->first()); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('password.email')); ?>" id="forgot_password_form"
                    class="needs-validation dms-login-form" novalidate="" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <div class="dms-form-group">
                        <label class="dms-label" for="email"><?php echo e(__('Email')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <path d="m4 7 8 6 8-6"></path>
                                </svg>
                            </span>
                            <input id="email" type="email"
                                class="form-control dms-login-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Enter your email')); ?>" required autofocus
                                autocapitalize="off" spellcheck="false">
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php echo $__env->yieldPushContent('recaptcha_field'); ?>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary forgot_button dms-submit-btn">
                            <?php echo e(__('Send Password Reset Link')); ?>

                        </button>
                    </div>

                    <p class="dms-register"><?php echo e(__('Remembered your password?')); ?>

                        <a href="<?php echo e(route('login', $lang)); ?>"><?php echo e(__('Back to login')); ?></a>
                    </p>
                    <p class="dms-note"><?php echo e(__('This app is free and open source, built to help your team grow with confidence.')); ?></p>
                </form>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            document.body.classList.add("faith-login-page", "dms-faith-login");

            $("#forgot_password_form").submit(function() {
                const button = $(".forgot_button");
                button.attr("disabled", true).addClass("disabled");
                setTimeout(() => {
                    button.attr("disabled", false).removeClass("disabled");
                }, 1500);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>