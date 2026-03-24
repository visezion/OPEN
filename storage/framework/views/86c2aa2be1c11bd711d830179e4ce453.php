<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('Footer')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="border">
            <?php echo e(Form::open(array('route' => 'footer_store', 'method'=>'post', 'enctype' => "multipart/form-data" , 'class'=>'needs-validation', 'novalidate' ))); ?>

                    <div class="border-bottom p-3 accordion-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5><?php echo e(__('Footer Details')); ?></h5>
                            </div>
                            <div id="p1" class="col-auto text-end text-primary h3">
                                <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/footersection.png')); ?>"
                                   data-url="<?php echo e(route('info.image.view',['landingpage','footer'])); ?>" class="view-images pt-2">
                                    <i class="ti ti-info-circle pointer"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('All Rights Reserve text', __('All Rights Reserve text'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('all_rights_reserve_text', $settings['all_rights_reserve_text'], ['class' => 'form-control', 'placeholder' => __('All Rights Reserve text')])); ?>

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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('All Rights Reserve Website Name', __('All Rights Reserve Website Name'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('all_rights_reserve_website_name', $settings['all_rights_reserve_website_name'], ['class' => 'form-control', 'placeholder' => __('All Rights Reserve Website Name')])); ?>

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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('All Rights Reserve Website URL', __('All Rights Reserve Website URL'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('all_rights_reserve_website_url', $settings['all_rights_reserve_website_url'], ['class' => 'form-control', 'placeholder' => __('All Rights Reserve Website URL')])); ?>

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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?php echo e(Form::label('Go To Shop Link', __('Go To Shop Link'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('footer_live_demo_link', $settings['footer_live_demo_link'], ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('Go To Shop Button Text', __('Go To Shop Button Text'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('footer_gotoshop_button_text',$settings['footer_gotoshop_button_text'], ['class' => 'form-control', 'placeholder' => __('Enter Button Text')])); ?>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?php echo e(Form::label('Support Button Link', __('Support Button Link'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('footer_support_link', $settings['footer_support_link'], ['class' => 'form-control', 'placeholder' => __('Enter Link')])); ?>

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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('Support Button Text', __('Support Button Text'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('footer_support_button_text',$settings['footer_support_button_text'], ['class' => 'form-control', 'placeholder' => __('Enter Button Text')])); ?>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo e(Form::label('Footer Description', __('Footer Description'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('footer_description', $settings['footer_description'], ['class' => 'form-control', 'placeholder' => __('Enter Description')])); ?>

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('Footer Logo', __('Footer Logo'), ['class' => 'form-label'])); ?>

                                    <div class="logo-content mt-4">
                                        <img id="image11" src="<?php echo e(check_file($settings['footer_logo']) ? get_file($settings['footer_logo']) : get_file('uploads/logo/logo_light.png')); ?>" class="small-logo"  style="filter: drop-shadow(2px 3px 7px #011C4B);">
                                    </div>
                                    <div class="choose-files mt-5">
                                        <label for="footer_logo">
                                            <div class=" bg-primary" style="cursor: pointer;transform: translateY(+110%);">
                                                <i class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                            </div>
                                            <input type="file" name="footer_logo" id="footer_logo" class="form-control choose_file_custom" data-filename="footer_logo">
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['footer_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="row">
                                        <span class="invalid-logo" role="alert">
                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                        </span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                    </div>
            <?php echo e(Form::close()); ?>

        </div>

        <div class="border mt-5">
            <div class="border-bottom p-3 accordion-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5><?php echo e(__('Footer Sections')); ?></h5>
                    </div>
                    <div id="p1" class="col-auto text-end text-primary h3">
                        <a image-url="<?php echo e(asset('packages/workdo/LandingPage/src/Resources/assets/infoimages/footersection.png')); ?>" data-id="1"
                           data-url="<?php echo e(route('info.image.view',['landingpage','footer'])); ?>" class="view-images pt-2">
                            <i class="ti ti-info-circle pointer"></i>
                        </a>
                    </div>
                    <div class="col-auto justify-content-end d-flex">
                        <a data-size="lg" data-url="<?php echo e(route('footer_section_create')); ?>" data-ajax-popup="true" title="<?php echo e(__('Create')); ?>" data-bs-toggle="tooltip" data-title="<?php echo e(__('Create New Section')); ?>"  class="btn btn-sm btn-primary">
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
                            <?php if(is_array($footer_sections_details) || is_object($footer_sections_details)): ?>
                            <?php
                                $of_no = 1
                            ?>
                                <?php $__currentLoopData = $footer_sections_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($of_no++); ?></td>
                                        <td><?php echo e($value['footer_section_heading']); ?></td>
                                        <td>
                                            <span>
                                                <div class="action-btn  me-2">
                                                        <a href="#" class="bg-info btn btn-sm align-items-center" data-url="<?php echo e(route('footer_section_edit',$key)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Page')); ?>" data-size="lg" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>

                                                <div class="action-btn">
                                                <?php echo Form::open(['method' => 'GET', 'route' => ['footer_section_delete', $key],'id'=>'delete-form-'.$key]); ?>


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
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\custom\footer\index.blade.php ENDPATH**/ ?>