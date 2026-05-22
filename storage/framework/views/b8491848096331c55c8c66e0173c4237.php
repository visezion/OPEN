<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Register')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('language-bar'); ?>
    <li class="lang-dropdown-only-desk dropdown dash-h-item drp-language">
        <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="drp-text"> <?php echo e(Str::upper($lang)); ?>

            </span>
        </a>
        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('register', ['lang' => $key, 'ref_id' => $ref])); ?>"
                    class="dropdown-item <?php if($lang == $key): ?> text-primary <?php endif; ?>">
                    <span><?php echo e(Str::ucfirst($language)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </li>
<?php $__env->stopSection(); ?>
<?php
    $admin_settings = getAdminAllSetting();
    $setting = Workdo\LandingPage\Entities\LandingPageSetting::settings();
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
                <h2><?php echo e(__('Centralized ministry operations in Christ Jesus')); ?></h2>
                <p><?php echo e(__('Prayer, service teams, outreach tasks, and reports from one trusted portal.')); ?></p>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label"><?php echo e(__('Ministry Admin Register')); ?></p>
                        <h2><?php echo e($auth_brand); ?></h2>
                        <p class="dms-card-copy"><?php echo e(__('Create your ministry workspace account')); ?></p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">&#10013;</div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="dms-error"><?php echo e($errors->first()); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('register')); ?>" class="needs-validation dms-login-form"
                    novalidate="" id="register_form_data" autocomplete="off">
                    <?php echo csrf_field(); ?>

                    <div class="dms-form-group">
                        <label class="dms-label" for="name"><?php echo e(__('Name')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M20 21a8 8 0 1 0-16 0"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input id="name" type="text" class="form-control dms-login-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="name" placeholder="<?php echo e(__('Enter name')); ?>" value="<?php echo e(old('name')); ?>" required
                                autocomplete="name" autofocus>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-name text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="dms-form-group">
                        <label class="dms-label" for="store_name"><?php echo e(__('WorkSpace Name')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                    <path d="M3 9h18"></path>
                                </svg>
                            </span>
                            <input id="store_name" type="text"
                                class="form-control dms-login-input <?php $__errorArgs = ['workspace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="workspace" placeholder="<?php echo e(__('Enter workspace name')); ?>"
                                value="<?php echo e(old('workspace')); ?>" required autocomplete="organization">
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['workspace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-workspace text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <input type="hidden" name="type" value="register" id="type">

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
                                placeholder="<?php echo e(__('Enter your email')); ?>" value="<?php echo e(old('email')); ?>" required
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
                        <label class="dms-label" for="register-password"><?php echo e(__('Password')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                </svg>
                            </span>
                            <input id="register-password" type="password"
                                class="form-control dms-login-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="password" placeholder="<?php echo e(__('Enter your password')); ?>" required
                                autocomplete="new-password">
                            <button type="button" id="toggle-register-password" class="dms-toggle-pass"
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

                    <div class="dms-form-group">
                        <label class="dms-label" for="password-confirm"><?php echo e(__('Confirm Password')); ?></label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                </svg>
                            </span>
                            <input id="password-confirm" type="password"
                                class="form-control dms-login-input <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="password_confirmation" placeholder="<?php echo e(__('Confirm your password')); ?>" required
                                autocomplete="new-password">
                            <button type="button" id="toggle-confirm-password" class="dms-toggle-pass"
                                aria-label="<?php echo e(__('Show password')); ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error invalid-password-confirm text-danger" role="alert">
                                <small><?php echo e($message); ?></small>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="dms-login-actions">
                        <label class="form-check dms-remember mb-0" for="termsCheckbox">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                            <span class="form-check-label">
                                <?php echo e(__('I agree to the')); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array(json_decode($setting['menubar_page'])) || is_object(json_decode($setting['menubar_page']))): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = json_decode($setting['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($value->page_slug, ['terms_and_conditions']) && isset($value->template_name)): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('LandingPage')): ?>
                                                <a href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"
                                                    target="_blank"><?php echo e($value->menubar_page_name); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('custompage', ['page' => 'terms_and_conditions'])); ?>"
                                                    target="_blank"><?php echo e(__('Terms and Conditions')); ?></a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php echo e(__('and the')); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = json_decode($setting['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($value->page_slug, ['privacy_policy']) && isset($value->template_name)): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('LandingPage')): ?>
                                                <a href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"
                                                    target="_blank"><?php echo e($value->menubar_page_name); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('custompage', ['page' => 'privacy_policy'])); ?>"
                                                    target="_blank"><?php echo e(__('Privacy Policy')); ?></a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </label>
                    </div>

                    <?php echo $__env->yieldPushContent('recaptcha_field'); ?>
                    <input type="hidden" name="ref_code" value="<?php echo e($ref); ?>">

                    <div class="d-grid">
                        <button class="btn btn-primary btn-block mt-2 register_button dms-submit-btn" type="submit">
                            <?php echo e(__('Create Account')); ?>

                        </button>
                        <?php echo $__env->yieldPushContent('SigninButton'); ?>
                    </div>

                    <p class="dms-register"><?php echo e(__('Already have an account?')); ?>

                        <a href="<?php echo e(route('login', $lang)); ?>"><?php echo e(__('Sign in')); ?></a>
                    </p>
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

            function bindToggle(buttonId, inputId) {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);
                if (!button || !input) {
                    return;
                }
                button.addEventListener("click", function() {
                    const isPassword = input.type === "password";
                    input.type = isPassword ? "text" : "password";
                    button.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
                });
            }

            bindToggle("toggle-register-password", "register-password");
            bindToggle("toggle-confirm-password", "password-confirm");

            $("#register_form_data").submit(function() {
                const button = $(".register_button");
                button.attr("disabled", true).addClass("disabled");
                setTimeout(() => {
                    button.attr("disabled", false).removeClass("disabled");
                }, 1500);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\auth\register.blade.php ENDPATH**/ ?>