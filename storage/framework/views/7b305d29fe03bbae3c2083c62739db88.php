<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('language-bar'); ?>
    <li class="lang-dropdown-only-desk dropdown dash-h-item drp-language">
        <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="drp-text"> <?php echo e(Str::upper($lang)); ?>

            </span>
        </a>
        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('login', ['lang' => $key, 'redirect_to' => $redirectTo ?? request('redirect_to')])); ?>"
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
    $auth_tagline = __('Faith-aligned operations in Christ Jesus');
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
                <h2><?php echo e(__('Centralized ministry operations in Christ Jesus')); ?></h2>
                <p><?php echo e(__('Prayer, service teams, outreach tasks, and reports from one trusted portal.')); ?></p>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label"><?php echo e(__('Ministry Admin Login')); ?></p>
                        <h2><?php echo e($auth_brand); ?></h2>
                        <p class="dms-card-copy"><?php echo e($auth_tagline); ?></p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">&#10013;</div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="dms-error"><?php echo e($errors->first()); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($redirectTo)): ?>
                    <div class="alert alert-info border mb-3">
                        <?php echo e(__('Sign in to continue back to your meeting room.')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>" class="needs-validation dms-login-form" novalidate=""
                    id="form_data" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($redirectTo)): ?>
                        <input type="hidden" name="redirect_to" value="<?php echo e($redirectTo); ?>">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

                    <div class="dms-form-group">
                        <label class="dms-label" for="login-password"><?php echo e(__('Password')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                </svg>
                            </span>
                            <input id="login-password" type="password"
                                class="form-control dms-login-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password"
                                placeholder="<?php echo e(__('Enter your password')); ?>" required autocomplete="new-password">
                            <button type="button" id="toggle-password" class="dms-toggle-pass"
                                aria-label="<?php echo e(__('Show password')); ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-password text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="dms-form-group dms-captcha-group">
                        <label class="dms-label" for="captcha-answer"><?php echo e(__('Security Captcha')); ?></label>
                        <div class="dms-captcha-shell">
                            <img id="captcha-image" class="dms-captcha-image" src="<?php echo e($captchaImage ?? ''); ?>"
                                alt="<?php echo e(__('Security captcha')); ?>">
                            <button type="button" id="captcha-refresh" class="dms-captcha-refresh">
                                <?php echo e(__('Refresh')); ?>

                            </button>
                        </div>
                        <div class="dms-field-wrap dms-captcha-input-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M7 4h10v16H7z"></path>
                                    <path d="M4 8h3M4 16h3"></path>
                                </svg>
                            </span>
                            <input id="captcha-answer" type="text"
                                class="form-control dms-login-input <?php $__errorArgs = ['captcha_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="captcha_answer" value="<?php echo e(old('captcha_answer')); ?>"
                                placeholder="<?php echo e(__('Enter captcha text')); ?>" required autocomplete="off"
                                autocapitalize="characters" spellcheck="false">
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['captcha_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-captcha text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="dms-login-actions">
                        <label class="form-check dms-remember mb-0" for="remember">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                <?php echo e(old('remember', true) ? 'checked' : ''); ?>>
                            <span class="form-check-label"><?php echo e(__('Remember me')); ?></span>
                        </label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request', $lang)); ?>"
                                class="dms-forgot"><?php echo e(__('Forgot your password?')); ?></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php echo $__env->yieldPushContent('recaptcha_field'); ?>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary login_button dms-submit-btn" tabindex="4">
                            <span><?php echo e(__('Sign In')); ?></span>
                        </button>
                        <?php echo $__env->yieldPushContent('SigninButton'); ?>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($admin_settings['signup']) || (isset($admin_settings['signup']) ? $admin_settings['signup'] : 'off') == 'on'): ?>
                        <p class="dms-register"><?php echo e(__("Don't have an account?")); ?>

                            <a href="<?php echo e(route('register', $lang)); ?>"><?php echo e(__('Create one now')); ?></a>
                        </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p class="dms-note"><?php echo e(__('Authorized ministry users only. Activity is monitored for accountability in Christ.')); ?></p>
                </form>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            document.body.classList.add("faith-login-page", "dms-faith-login");

            const passwordInput = document.getElementById("login-password");
            const togglePassword = document.getElementById("toggle-password");
            const captchaRefresh = document.getElementById("captcha-refresh");
            const captchaImage = document.getElementById("captcha-image");
            const captchaAnswer = document.getElementById("captcha-answer");
            if (passwordInput && togglePassword) {
                togglePassword.addEventListener("click", function() {
                    const isPassword = passwordInput.type === "password";
                    passwordInput.type = isPassword ? "text" : "password";
                    togglePassword.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
                });
            }

            if (captchaAnswer) {
                captchaAnswer.addEventListener("input", function() {
                    this.value = (this.value || "").replace(/[^A-Za-z0-9]/g, "").toUpperCase();
                });
            }

            if (captchaRefresh && captchaImage) {
                captchaRefresh.addEventListener("click", async function() {
                    try {
                        captchaRefresh.disabled = true;
                        const response = await fetch("<?php echo e(route('login.captcha.refresh')); ?>", {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            credentials: "same-origin"
                        });
                        const data = await response.json();
                        if (data && data.ok && typeof data.captcha_image === "string") {
                            captchaImage.src = data.captcha_image;
                            if (captchaAnswer) {
                                captchaAnswer.value = "";
                                captchaAnswer.focus();
                            }
                        }
                    } catch (e) {
                    } finally {
                        captchaRefresh.disabled = false;
                    }
                });
            }

            $("#form_data").submit(function() {
                const button = $(".login_button");
                button.attr("disabled", true).addClass("disabled");
                setTimeout(() => {
                    button.attr("disabled", false).removeClass("disabled");
                }, 1500);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/auth/login.blade.php ENDPATH**/ ?>