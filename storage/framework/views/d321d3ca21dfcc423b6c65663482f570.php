<?php
    if (Auth::user()->type == 'super admin') {
        $plural_name = __('Customers');
        $singular_name = __('Customer');
    } else {
        $plural_name = __('Users');
        $singular_name = __('User');
    }
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_disable == 1 || Auth::user()->type == 'super admin'): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->type == 'super admin'): ?>
        <div class="action-btn me-2">
            <a data-url="<?php echo e(route('company.info', $user->id)); ?>"
                class="btn btn-sm d-inline-flex align-items-center bg-primary" data-ajax-popup="true" data-size="lg"
                data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Admin Hub')); ?>"
                data-title="<?php echo e(__('Company Info')); ?>"> <span class="text-white"><i class="ti ti-atom"></i></a>
        </div>
        <div class="action-btn me-2">
            <a href="<?php echo e(route('login.with.company', $user->id)); ?>"
                class="btn btn-sm d-inline-flex align-items-center bg-secondary" data-bs-toggle="tooltip"
                data-bs-original-title="<?php echo e(__('Login As Company')); ?>"> <span class="text-white"><i
                        class="ti ti-replace"></i></a>
        </div>
        <div class="action-btn me-2">
            <a href="#!" data-url="<?php echo e(route('upgrade.plan', $user->id)); ?>" data-ajax-popup="true" data-size="xl"
                class="btn btn-sm d-inline-flex align-items-center bg-primary" data-bs-toggle="tooltip"
                data-title="<?php echo e(__('Upgrade Plan')); ?>" data-bs-original-title="<?php echo e(__('Upgrade Plan')); ?>">
                <span class="text-white"><i class="ti ti-trophy"></i></span>
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(admin_setting('email_verification') == 'on' && $user->email_verified_at == null): ?>
        <div class="action-btn me-2">
            <a href="<?php echo e(route('user.verified', $user->id)); ?>" class="btn btn-sm d-inline-flex align-items-center bg-secondary"  data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Verified Now')); ?>"> <span class="text-white"><i class="ti ti-checks"></i></a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if (app('laratrust')->hasPermission('user reset password')) : ?>
        <div class="action-btn me-2">
            <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-warning"
                data-url="<?php echo e(route('users.reset', \Crypt::encrypt($user->id))); ?>" data-ajax-popup="true"
                data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Reset Password')); ?>"
                data-title="<?php echo e(__('Reset Password')); ?>"> <span class="text-white"><i class="ti ti-adjustments"></i></a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user login manage')) : ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_enable_login == 1): ?>
            <div class="action-btn me-2">
                <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>"
                    class="btn btn-sm d-inline-flex align-items-center bg-danger" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Login Disable')); ?>"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        <?php elseif($user->is_enable_login == 0 && $user->password == null): ?>
            <div class="action-btn me-2">
                <a href="#" data-url="<?php echo e(route('users.reset', \Crypt::encrypt($user->id))); ?>" data-ajax-popup="true"
                    data-size="md" class="btn btn-sm d-inline-flex align-items-center login_enable bg-secondary"
                    data-title="<?php echo e(__('New Password')); ?>" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('New Password')); ?>"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        <?php else: ?>
            <div class="action-btn me-2">
                <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>"
                    class="btn btn-sm d-inline-flex align-items-center login_enable bg-success" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Login Enable')); ?>"> <span class="text-white"> <i
                            class="ti ti-road-sign"></i>
                </a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user edit')) : ?>
        <div class="action-btn me-2">
            <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-info"
                data-url="<?php echo e(route('users.edit', $user->id)); ?>" class="dropdown-item" data-ajax-popup="true"
                data-title="<?php echo e(__('Update ' . $singular_name)); ?>" data-bs-toggle="tooltip"
                data-bs-original-title="<?php echo e(__('Edit')); ?>"> <span class="text-white"> <i
                        class="ti ti-pencil"></i></span></a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user delete')) : ?>
        <div class="action-btn">
            <?php echo e(Form::open(['route' => ['users.destroy', $user->id], 'class' => 'm-0'])); ?>

            <?php echo method_field('DELETE'); ?>
            <a href="#" class="btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('Delete')); ?>"
                aria-label="<?php echo e(__('Delete')); ?>" data-confirm-yes="delete-form-<?php echo e($user->id); ?>"><i
                    class="ti ti-trash text-white"></i></a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php else: ?>
    <div class="action-btn">
        <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-dark" data-title="<?php echo e(__('Lock')); ?>"
            data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('User Is Disable')); ?>"><span class="text-white"><i
                    class="ti ti-lock"></i></span></a>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\users\action.blade.php ENDPATH**/ ?>