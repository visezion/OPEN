<div class="border">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__(' ')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/reviewsection.png')); ?>"
                   data-url="<?php echo e(route('info.image.view',['landingpage','review'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
            <div class="col-auto justify-content-end d-flex">
                <a data-size="lg" data-url="<?php echo e(route('review_create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Review  ')); ?>"  class="btn btn-sm btn-primary">
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
                        <th><?php echo e(__('Heading')); ?></th>
                        <th class="text-center"><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($reviews) || is_object($reviews)): ?>
                   <?php
                       $ff_no = 1
                   ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ff_no++); ?></td>
                                <td><?php echo e($value['review_heading']); ?></td>
                                <td class="text-center">
                                    <span>
                                        <div class="action-btn me-2">
                                                <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('review_edit',$key)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Review')); ?>" data-size="lg" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                        <div class="action-btn">
                                        <?php echo Form::open(['method' => 'GET', 'route' => ['review_delete', $key],'id'=>'delete-form-'.$key]); ?>

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


<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\reviews\index.blade.php ENDPATH**/ ?>