    
    <?php $__env->startSection('page-title'); ?>
        <?php echo e(__('Register')); ?>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('language-bar'); ?>
        <div class="lang-dropdown-only-desk">
            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="drp-text"> <?php echo e(Str::upper($lang)); ?>

                    </span>
                </a>
                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                    <?php $__currentLoopData = languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('register', [$ref ,$key])); ?>"
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
        $setting = Workdo\LandingPage\Entities\LandingPageSetting::settings();
    ?>

    <?php $__env->startSection('content'); ?>
        <div class="card">
            <form method="POST" action="<?php echo e(route('register')); ?>" class="needs-validation" novalidate="">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="">
                        <h2 class="mb-3 f-w-600"><?php echo e(__('Register')); ?></h2>
                    </div>
                    <div class="">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Name')); ?></label>
                            <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="name" placeholder="<?php echo e(__('Enter Name')); ?>" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-name text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('WorkSpace Name')); ?></label>
                            <input id="store_name" type="text" class="form-control <?php $__errorArgs = ['store_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="workspace" placeholder="<?php echo e(__('Enter WorkSpace Name')); ?>" value="<?php echo e(old('store_name')); ?>" required autocomplete="store_name">
                            <?php $__errorArgs = ['workspace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-name text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <input type="hidden" name = "type" value="register" id="type">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Email')); ?></label>
                            <input id="email" type="email" class="form-control  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="email" placeholder="<?php echo e(__('Enter Email')); ?>" value="<?php echo e(old('email')); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-email text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Password')); ?></label>
                            <input id="password" type="password" class="form-control  <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="password" placeholder= "<?php echo e(__('Enter Password')); ?>" required autocomplete="new-password">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-password text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>


                        <div class="form-group">
                            <label class="form-label"><?php echo e(__('Confirm password')); ?></label>
                            <input id="password-confirm" type="password"
                                class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="password_confirmation" placeholder="<?php echo e(__('Enter Confirm password')); ?>" required autocomplete="new-password">
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-password_confirmation text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-check ">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                            <label class="form-check-label text-sm" for="termsCheckbox"><?php echo e(__('I agree to the ')); ?>

                                <?php if(is_array(json_decode($setting['menubar_page'])) || is_object(json_decode($setting['menubar_page']))): ?>
                                    <?php $__currentLoopData = json_decode($setting['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($value->page_slug, ['terms_and_conditions']) && isset($value->template_name)): ?>
                                            <?php if(module_is_active('LandingPage')): ?>
                                                <a href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"
                                                    target="_blank"><?php echo e($value->menubar_page_name); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('custompage', ['page'=>'terms_and_conditions'])); ?>"
                                                target="_blank"><?php echo e(__('Terms and Conditions')); ?></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(__('and the ')); ?>

                                    <?php $__currentLoopData = json_decode($setting['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($value->page_slug, ['privacy_policy']) && isset($value->template_name)): ?>
                                            <?php if(module_is_active('LandingPage')): ?>
                                                <a href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"
                                                target="_blank"><?php echo e($value->menubar_page_name); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('custompage', ['page'=>'privacy_policy'])); ?>"
                                                target="_blank"><?php echo e(__('Privacy Policy')); ?></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </label>
                        </div>
                        <?php echo $__env->yieldPushContent('recaptcha_field'); ?>
                        <div class="d-grid">
                            <input type="hidden" name="ref_code" value="<?php echo e($ref); ?>">
                            <button class="btn btn-primary btn-block mt-2" type="submit"><?php echo e(__('Register')); ?></button>
                            <?php echo $__env->yieldPushContent('SigninButton'); ?>
                        </div>

                    </div>
                    <p class="mb-0 my-4 text-center"><?php echo e(__('Already have an account?')); ?> <a
                            href="<?php echo e(route('login', $lang)); ?>" class="f-w-400 text-primary"><?php echo e(__('Login')); ?></a></p>
                </div>
            </form>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\auth\register.blade.php ENDPATH**/ ?>