<div class="border mb-5">
    <div class="p-3 border-bottom accordion-header">
        <div class="row">
            <div class="col accordion-header">
                <h5><?php echo e(__('Feature Head Details')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/featuresections.png')); ?>" data-id="1"
                   data-url="<?php echo e(route('info.image.view',['landingpage','features'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
        </div>
    </div>
    <?php echo e(Form::open(array('route' => 'feature_highlight_store', 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('highlight_feature_heading', __('Heading'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('highlight_feature_heading', $settings['highlight_feature_heading'], ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['highlight_feature_heading'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-mail_port" role="alert">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('highlight_feature_heading', __('Description'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('highlight_feature_description', $settings['highlight_feature_description'], ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['highlight_feature_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-mail_port" role="alert">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
        </div>
    <?php echo e(Form::close()); ?>

</div>

<div class="border mb-5">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col accordion-header">
                <h5><?php echo e(__('Feature Cards')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/featurecards.png')); ?>"
                   data-url="<?php echo e(route('info.image.view',['landingpage','features'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
            <div class="col-auto justify-content-end d-flex">
                <a data-size="lg" data-url="<?php echo e(route('feature_create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Feature Cards
                  ')); ?>"  class="btn btn-sm btn-primary">
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
                        <th class="text-center"><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                   <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($feature_of_features) || is_object($feature_of_features)): ?>
                   <?php
                       $ff_no = 1
                   ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $feature_of_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ff_no++); ?></td>
                                <td><?php echo e($value['feature_heading']); ?></td>
                                <td class="text-center">
                                    <span>
                                        <div class="action-btn  me-2">
                                                <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('feature_edit',$key)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Feature Cards')); ?>" data-size="lg" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                        <div class="action-btn ">
                                        <?php echo Form::open(['method' => 'GET', 'route' => ['feature_delete', $key],'id'=>'delete-form-'.$key]); ?>

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

<div class="border">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('Feature Sections')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/featuresections.png')); ?>" data-id="1"
                   data-url="<?php echo e(route('info.image.view',['landingpage','features'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
            <div class="col-auto justify-content-end d-flex">
                <a data-size="lg" data-url="<?php echo e(route('features_create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Feature Section')); ?>"  class="btn btn-sm btn-primary">
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($feature_of_features) || is_object($feature_of_features)): ?>
                    <?php
                        $of_no = 1
                    ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $other_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($of_no++); ?></td>
                                <td><?php echo e($value['other_features_heading']); ?></td>
                                <td>
                                    <span>
                                        <div class="action-btn  me-2">
                                                <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('features_edit',$key)); ?>" data-ajax-popup="true"   data-title="<?php echo e(__('Edit Feature Section')); ?>" data-size="lg" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                            <div class="action-btn">
                                            <?php echo Form::open(['method' => 'GET', 'route' => ['features_delete', $key],'id'=>'delete-form-'.$key]); ?>


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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\features\index.blade.php ENDPATH**/ ?>