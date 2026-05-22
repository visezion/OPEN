<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Notification Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Notification Templates')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div>
        <a href="<?php echo e(route('notification-template.index')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            data-bs-placement="top" title="<?php echo e(__('return')); ?>"><i class="ti ti-arrow-back-up"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header card-body">
                    <h5></h5>
                    <div class="row text-xs">

                        <h6 class="font-weight-bold mb-4"><?php echo e(__('Variables')); ?></h6>
                        <?php
                            $variables = json_decode($currTempLang->variables);
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($variables) > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-6 pb-1">
                                    <p class="mb-1"><?php echo e(__($key)); ?> : <span
                                            class="pull-right text-primary"><?php echo e('{' . $var . '}'); ?></span></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h5></h5>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
                    <div class="card sticky-top language-sidebar">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="list-group-item list-group-item-action  <?php echo e($currTempLang->lang == $key ? 'active' : ''); ?>"
                                    href="<?php echo e(route('manage.notification.language', [$notification->id, $key])); ?>">
                                    <?php echo e(Str::ucfirst($lang)); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9  card">
                    <?php echo e(Form::model($currTempLang, ['route' => ['store.notification.language', $currTempLang->parent_id], 'method' => 'POST'])); ?>

                    <div class="row">
                        <div class="form-group col-12">
                            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label text-dark'])); ?>

                            <?php echo e(Form::text('name', $notification->action, ['class' => 'form-control font-style', 'disabled' => 'disabled'])); ?>

                        </div>
                        <div class="form-group col-12">
                            <?php echo e(Form::label('content', __('Notification Message'), ['class' => 'col-form-label text-dark'])); ?>

                            <?php echo e(Form::textarea('content', $currTempLang->content, ['class' => 'form-control font-style', 'required' => 'required'])); ?>

                        </div>
                        <div class="col-md-12 text-end mb-3">
                            <?php echo e(Form::hidden('lang', null)); ?>

                            <?php echo e(Form::hidden('module', $notification->module)); ?>

                            <?php echo e(Form::hidden('variables', $currTempLang->variables)); ?>

                            <input type="submit" value="<?php echo e(__('Save')); ?>"
                                class="btn btn-print-invoice  btn-primary m-r-10">
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\notification_templates\show.blade.php ENDPATH**/ ?>