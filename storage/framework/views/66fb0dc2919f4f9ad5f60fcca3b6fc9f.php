
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<div class="border mb-5">
    <?php echo e(Form::open(array('route' => 'faq.store', 'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

        <div class="p-3 border-bottom accordion-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h5 class="mb-2"><?php echo e(__('Main')); ?></h5>
                    <small class="text-danger"><?php echo e(__('Note: This section is for Pricing page ')); ?></small>
                </div>
                
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('Heading', __('Heading'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('faq_heading',$settings['faq_heading'], ['class' => 'form-control ', 'placeholder' => __('Enter Heading')])); ?>

                        <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-mail_driver" role="alert">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo e(Form::label('Description', __('Description'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::textarea('faq_description', $settings['faq_description'], ['class' => 'summernote form-control', 'rows'=>5, 'placeholder' => __('Enter Description'),'required'=>'required'])); ?>

                        <?php $__errorArgs = ['mail_port'];
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
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>



            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-print-invoice btn-primary m-r-10" type="submit" ><?php echo e(__('Save Changes')); ?></button>
        </div>
    <?php echo e(Form::close()); ?>


</div>


<div class="border mb-5">
    <div class="p-3 border-bottom accordion-header">
        <div class="row align-items-center">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="col-6">
                    <h5 class="mb-2"><?php echo e(__('Info')); ?></h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                <a data-size="lg" data-url="<?php echo e(route('faq_create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Info')); ?>" data-original-title="<?php echo e(__('Create Info')); ?>" class="btn btn-sm btn-primary">
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
                   <?php if(is_array($faqs) || is_object($faqs)): ?>
                    <?php
                        $no = 1
                    ?>
                        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($no++); ?></td>
                                <td><?php echo e($value['faq_questions']); ?></td>
                                <td>
                                    <span>

                                        <div class="action-btn me-2">
                                            <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('faq_edit',$key)); ?>" data-ajax-popup="true" title="<?php echo e(__('Edit')); ?>" data-size="lg" data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Edit Info')); ?>" data-title="<?php echo e(__('Edit Info')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                            <div class="action-btn">
                                                <?php echo Form::open(['method' => 'GET', 'route' => ['faq_delete', $key],'id'=>'delete-form-'.$key]); ?>

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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\details\faq\index.blade.php ENDPATH**/ ?>