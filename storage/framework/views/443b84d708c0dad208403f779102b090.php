<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $__env->make('landingpage::marketplace.modules', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card sticky-top" style="top:30px">
                            <div class="list-group list-group-flush" id="useradd-sidenav">

                                <?php echo $__env->make('landingpage::marketplace.tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                    

                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5><?php echo e(__('Upload Screenshots')); ?></h5>
                                </div>
                                <div id="p1" class="col-auto text-end text-primary h3">
                                    <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/screenshots.png')); ?>"
                                       data-url="<?php echo e(route('info.image.view',['marketplace','screenshots'])); ?>" class="view-images pt-2">
                                        <i class="ti ti-info-circle pointer"></i>
                                    </a>
                                </div>
                                <div class="col-auto justify-content-end d-flex">
                                    <a data-size="mx" data-url="<?php echo e(route('marketplace_screenshots_create',$slug)); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Screenshots ')); ?>"  class="btn btn-sm btn-primary">
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
                                                                    <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('marketplace_screenshots_edit',[$slug , $key])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Screenshots')); ?>" data-size="mx" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>

                                                                <div class="action-btn">
                                                                <?php echo Form::open(['method' => 'GET', 'route' => ['marketplace_screenshots_delete', [$slug , $key]],'id'=>'delete-form-'.$key]); ?>


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




                
                    </div>
                </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\marketplace\screenshots\index.blade.php ENDPATH**/ ?>