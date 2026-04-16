<div class="border">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('Info')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/screenshotsection.png')); ?>"
                   data-url="<?php echo e(route('info.image.view',['landingpage','screenshots'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
            <div class="col-auto justify-content-end d-flex">
                <a data-size="mx" data-url="<?php echo e(route('screenshots_create')); ?>" data-ajax-popup="true" title="<?php echo e(__('Create Screenshots')); ?>" data-bs-toggle="tooltip" data-title="<?php echo e(__('Create Screenshots')); ?>"  class="btn btn-sm btn-primary">
                    <i class="ti ti-plus text-light"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo e(__('No')); ?></th>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($screenshots) || is_object($screenshots)): ?>
                   <?php
                        $no = 1
                    ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $screenshots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($no++); ?></td>
                                <td><?php echo e($value['screenshots_heading']); ?></td>
                                <td>
                                    <span>
                                        <div class="action-btn  me-2">
                                                <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('screenshots_edit',$key)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Screenshot')); ?>" data-size="mx" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit Info')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn ">
                                            <?php echo Form::open(['method' => 'GET', 'route' => ['screenshots_delete', $key],'id'=>'delete-form-'.$key]); ?>

                                                <a href="#" class="bg-danger btn btn-sm align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm-yes="<?php echo e('delete-form-'.$key); ?>">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                                <?php echo Form::close(); ?>

                                            </div>
                                        </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\screenshots\index.blade.php ENDPATH**/ ?>