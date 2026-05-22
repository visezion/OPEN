
  <span>
    <?php 
    $user = $member->user;
    ?>
    
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
 
    <?php if (app('laratrust')->hasPermission('church_member show')) : ?>
    <div class="action-btn  me-2">
        <a href="<?php echo e(route('members.show', \Illuminate\Support\Facades\Crypt::encrypt( $member->id))); ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
    <?php endif; // app('laratrust')->permission ?>

    <?php if (app('laratrust')->hasPermission('church_member edit')) : ?>
    <div class="action-btn  me-2">
        <a href="<?php echo e(route('members.edit', \Illuminate\Support\Facades\Crypt::encrypt( $member->id))); ?>" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
           
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
    <?php endif; // app('laratrust')->permission ?>

    <?php if (app('laratrust')->hasPermission('church_member delete')) : ?>
        <?php echo Form::open(['method' => 'DELETE', 'route' => ['members.destroy', $member->id], 'style'=>'display:inline']); ?>

            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                <i class="ti ti-trash"></i>
            </button>
        <?php echo Form::close(); ?>

    <?php endif; // app('laratrust')->permission ?>
</span>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\button.blade.php ENDPATH**/ ?>