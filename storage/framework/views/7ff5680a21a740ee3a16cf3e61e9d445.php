
<div class="border mb-5">

    <?php echo e(Form::open(array('route' => 'buildtech_store', 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

        <div class="p-3 border-bottom accordion-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5><?php echo e(__('Main')); ?></h5>
                </div>
                <div id="p1" class="col-auto text-end text-primary h3">
                    <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/buildtechsectiondetails.png')); ?>"
                       data-url="<?php echo e(route('info.image.view',['landingpage','buildtech'])); ?>" class="view-images pt-2">
                        <i class="ti ti-info-circle pointer"></i>
                    </a>
                </div>
                
            </div>
        </div>


        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('buildtech heading', __('Heading'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('buildtech_heading', $settings['buildtech_heading'], ['class' => 'form-control', 'placeholder' => __('Enter Heading')])); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('buildtech heading', __('Description'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('buildtech_description', $settings['buildtech_description'], ['class' => 'form-control', 'placeholder' => __('Enter Description')])); ?>

                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
        </div>
    <?php echo e(Form::close()); ?>




</div>

<div class="border">
    <div class="p-3 border-bottom accordion-header" >
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('BuildTech Section Cards')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/buildtechsectioncards.png')); ?>" data-id="1"
                   data-url="<?php echo e(route('info.image.view',['landingpage','buildtech'])); ?>" class="view-images pt-2">
                    <i class="ti ti-info-circle pointer"></i>
                </a>
            </div>
            <div class="col-auto justify-content-end">
                <a data-size="lg" data-url="<?php echo e(route('buildtech_card_create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip"  title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Card')); ?>"  class="btn btn-sm btn-primary">
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
                    <?php if(is_array($buildtech_card_details) || is_object($buildtech_card_details)): ?>
                    <?php
                        $ff_no = 1
                    ?>
                        <?php $__currentLoopData = $buildtech_card_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ff_no++); ?></td>
                                <td><?php echo e($value['buildtech_card_heading']); ?></td>
                                <td class="text-center">
                                    <span>
                                        <div class="action-btn me-2">
                                                <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('buildtech_card_edit',$key)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Card')); ?>" data-size="lg" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                        <div class="action-btn">
                                        <?php echo Form::open(['method' => 'GET', 'route' => ['buildtech_card_delete', $key],'id'=>'delete-form-'.$key]); ?>

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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\buildtech\index.blade.php ENDPATH**/ ?>