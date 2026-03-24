
<div class="border">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <h5><?php echo e(__('Info')); ?></h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo e(__('Email')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($join_us) && (is_array($join_us) || is_object($join_us))): ?>
                    <?php $__currentLoopData = $join_us; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($value->email); ?></td>
                        <td>
                            <span>
                                <div class="action-btn">
                                    <?php echo Form::open(['method' => 'GET', 'route' => ['join_us_destroy', $value->id],'id'=>'delete-form-'.$key]); ?>

                                        <a href="#" class="bg-danger btn btn-sm align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm-yes="<?php echo e('delete-form-'.$key); ?>">
                                        <i class="ti ti-trash text-white"></i>
                                        </a>
                                    <?php echo Form::close(); ?>

                                </div>
                            </span>
                        </td>
                    </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\newsletter\join_user\index.blade.php ENDPATH**/ ?>