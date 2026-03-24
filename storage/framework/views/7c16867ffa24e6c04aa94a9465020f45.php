<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Landing Page')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <a class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Qr Code')); ?>" data-bs-toggle="modal"  data-bs-target="#qrcodeModal" id="download-qr"
        target="_blanks" >
        <span class="text-white"><i class="fa fa-qrcode"></i></span>
    </a>
    <a class="btn btn-sm btn-primary btn-icon ml-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
    data-bs-original-title="<?php echo e(__('Preview')); ?>" href="<?php echo e(url('/')); ?>" target="-blank" ><span
    class="text-white"><i class="ti ti-eye"></i></span></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $__env->make('landingpage::landingpage.sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5><?php echo e(__('SEO')); ?></h5>
                        </div>
                        <div id="p1" class="col-auto text-end text-primary h3">
                        </div>
                    </div>
                </div>
                <?php echo e(Form::open(['url' => route('landingpage.seo.setting.save'), 'method' => 'post', 'enctype' => 'multipart/form-data','class'=>'needs-validation', 'novalidate'])); ?>

                <div class="p-3 justify-content-center">
                    <div class="col-sm-12 col-md-10 col-xxl-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_title', __('Meta Title'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('meta_title', !empty($settings['meta_title']) ? $settings['meta_title'] :null, ['class' => 'form-control ','required'=>'required','placeholder' => 'Meta Title'])); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::textarea('meta_keywords', !empty($settings['meta_keywords']) ? $settings['meta_keywords'] :null , ['class' => 'form-control ','required'=>'required','placeholder' => 'Meta Keywords','rows'=>2])); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo e(Form::label('meta_description', __('Meta Description'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::textarea('meta_description', !empty($settings['meta_description']) ? $settings['meta_description'] :null , ['class' => 'form-control ','required'=>'required','placeholder' => 'Meta Description','rows'=>3])); ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mx-5">
                                        <div class="form-group mb-0">
                                        <?php echo e(Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label'])); ?>

                                        </div>
                                        <div class="setting-card">
                                            <div class="logo-content">
                                                <img id="image2" src="<?php echo e(get_file( (!empty($settings['meta_image'])) ? (check_file($settings['meta_image'])) ?  $settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  )); ?><?php echo e('?'.time()); ?>"
                                                    class="img_setting seo_image">
                                            </div>
                                            <div class="choose-files mt-4">
                                                <label for="meta_image">
                                                    <div class="bg-primary company_favicon_update"> <i
                                                            class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                    </div>
                                                    <input type="file" class="form-control file" accept="image/png, image/gif, image/jpeg,image/jpg"  id="meta_image" name="meta_image" onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0])"
                                                        data-filename="meta_image">
                                                </label>
                                            </div>
                                            <?php $__errorArgs = ['meta_image'];
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
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                </div>
                <?php echo e(Form::close()); ?>

            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5><?php echo e(__('Pixel Fields')); ?></h5>
                        </div>
                        <div class="col-auto justify-content-end d-flex">
                            <a data-size="lg" data-url="<?php echo e(route('landingpagePixel.create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Pixel Field')); ?>"  class="btn btn-sm btn-primary">
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
                                    <th><?php echo e(__('PLATFORM')); ?></th>
                                    <th><?php echo e(__('PIXEL ID')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($pixels) && (is_array($pixels) || is_object($pixels))): ?>
                                <?php $__currentLoopData = $pixels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($pixals_platforms[$value->platform]); ?></td>
                                    <td><?php echo e($value->pixel_id); ?></td>
                                    <td>
                                        <span>
                                            <div class="action-btn me-2">
                                                <a data-size="lg" data-url="<?php echo e(route('landingpagePixel.edit', $value->id)); ?>" data-ajax-popup="true"
                                                    class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit Pixel Field')); ?>"
                                                    title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['landingpagePixel.destroy', $value->id],'id'=>'delete-form-'.$key]); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\seo\index.blade.php ENDPATH**/ ?>