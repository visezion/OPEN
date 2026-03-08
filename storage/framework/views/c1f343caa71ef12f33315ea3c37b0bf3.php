
<?php echo e(Form::open(['route' => 'plan.store', 'enctype' => 'multipart/form-data','class'=>'needs-validation','novalidate'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::text('name', null, ['class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Plan Name')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('is_free_plan', __('Plan Type'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::select('is_free_plan',$plan_type, null, ['class' => 'form-control','required'=>'required','id'=>'is_free_plan', 'placeholder' => __('--- Select Plan Type ---')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('number_of_user', __('Number of User'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::number('number_of_user', null, ['class' => 'form-control','required'=>'required','placeholder' => __('Number of User'),'step' => '1','id'=>'number_of_user'])); ?>

                <span class="small text-danger"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('number_of_workspace', __('Number of Workspace'), ['class' => 'form-label'])); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                <?php echo e(Form::number('number_of_workspace', null, ['class' => 'form-control','required'=>'required','placeholder' => __('Number of Workspace'),'step' => '1','id'=>'number_of_workspace'])); ?>

                <span class="small text-danger"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
            </div>
        </div>
        <div class="col-md-6 plan_price_div">
            <div class="form-group">
                <?php echo e(Form::label('package_price_monthly', __('Basic Package Price/Month').' ( '.company_setting('defult_currancy_symbol').' )', ['class' => 'form-label add_lable'])); ?>

                <?php echo e(Form::number('package_price_monthly',null, ['class' => 'form-control ','placeholder' => __('Price/month'),'step' => '0.1','min'=>'0'])); ?>

            </div>
        </div>
        <div class="col-md-6 plan_price_div">
            <div class="form-group">
                <?php echo e(Form::label('package_price_yearly', __('Basic Package Price/Year').' ( '.company_setting('defult_currancy_symbol').' )', ['class' => 'form-label add_lable'])); ?>

                <?php echo e(Form::number('package_price_yearly',null, ['class' => 'form-control','placeholder' => __('Price/Yearly'),'step' => '0.1','min'=>'0'])); ?>

            </div>
        </div>
        <div class="col-md-6 mt-3 plan_price_div">
            <label class="form-check-label" for="trial"></label>
            <div class="form-group">
                <label for="trial" class="form-label"><?php echo e(__('Trial is enable(on/off)')); ?></label>
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="trial" class="form-check-input input-primary pointer" value="1" id="trial" <?php echo e(company_setting('trial')=='on'?' checked ':''); ?>>
                    <label class="form-check-label" for="trial"></label>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-none plan_div plan_price_div">
            <div class="form-group">
                <?php echo e(Form::label('trial_days', __('Trial Days'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('trial_days',null, ['class' => 'form-control','placeholder' => __('Enter Trial days'),'step' => '1','min'=>'1'])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('add_on', __('Add-on'), ['class' => 'form-label'])); ?>

            </div>
        </div>
        <?php if(count($modules)): ?>
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!isset($module->display) || $module->display == true): ?>
                <div class="col-sm-6 col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar">
                                            <img src="<?php echo e($module->image); ?><?php echo e('?'.time()); ?>" alt="<?php echo e($module->name); ?>" class="img-user rounded" style="max-width: 100%"  >
                                        </div>
                                        <div class="ms-3">
                                            <label for="<?php echo e($module->name); ?>">
                                                <h5 class="mb-0 pointer"><?php echo e($module->alias); ?></h5>
                                            </label>
                                            <p class="text-muted text-sm mb-0">
                                                <?php echo e($module->description ?? ''); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input modules" name="modules[]" value="<?php echo e($module->name); ?>" id="<?php echo e($module->name); ?>" type="checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-lg-12 col-md-12">
                <div class="card p-5">
                    <div class="d-flex justify-content-center">
                        <div class="ms-3 text-center">
                            <h3><?php echo e(__('Add-on Not Available')); ?></h3>
                            <p class="text-muted"><?php echo e(__('Click ')); ?><a
                                    href="<?php echo e(route('module.index')); ?>"><?php echo e(__('here')); ?></a>
                                <?php echo e(__('To Acctive Add-on')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn  btn-primary'))); ?>

</div>
<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\plans\create.blade.php ENDPATH**/ ?>