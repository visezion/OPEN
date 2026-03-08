

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Feedback')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Feedbacks')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
 <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <a href="<?php echo e(route('feedback.index')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><?php echo e(__('Edit Feedback')); ?></h5>
            </div>

            <div class="card-body">
                <?php echo Form::model($feedback, [
                    'route' => ['feedback.update', Crypt::encrypt($feedback->id)],
                    'method' => 'PUT',
                    'enctype' => 'multipart/form-data'
                ]); ?>


                
                <div class="mb-3">
                    <?php echo e(Form::label('title', __('Title'))); ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <?php echo e(Form::text('title', null, ['class' => 'form-control', 'required'])); ?>

                </div>

                
                <div class="mb-3">
                    <?php echo e(Form::label('category', __('Category'))); ?>

                    <?php echo e(Form::select('category', [
                        'suggestion' => 'Suggestion',
                        'complaint' => 'Complaint',
                        'praise' => 'Praise',
                        'other' => 'Other'
                    ], null, ['class' => 'form-control'])); ?>

                </div>

                
                <pre class="mb-3">
                    <?php echo e(Form::label('message', __('Message'))); ?> <?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                    <?php echo e(Form::textarea('message', null, [
                        'class' => 'form-control summernote',
                        'rows' => 8,
                        'style' => 'background-color: #f9f9f9; border-left: 5px solid #ccc;',
                        'placeholder' => __('Write your feedback...')
                    ])); ?>

                </pre>
                 
                <div class="form-check form-switch mb-3">
                    <?php echo e(Form::checkbox('is_anonymous', 1, $feedback->is_anonymous, ['class' => 'form-check-input', 'id' => 'is_anonymous'])); ?>

                    <?php echo e(Form::label('is_anonymous', __('Submit as Anonymous'), ['class' => 'form-check-label'])); ?>

                </div>
            </div>    
        </div> 
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><?php echo e(__('Attachment Information')); ?></h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <?php echo e(Form::label('attachment', __('Replace Attachment (Optional)'))); ?>

                    <?php echo e(Form::file('attachment', ['class' => 'form-control'])); ?>


                    <?php if($feedback->attachment): ?>
                        <div class="mt-3">
                            <strong><?php echo e(__('Current Attachment')); ?>:</strong><br>

                            <?php
                                $fileUrl = asset('storage/' . $feedback->attachment);
                                $fileName = basename($feedback->attachment);
                                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            ?>

                              <?php if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                               
                            <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="<?php echo e($fileUrl); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="<?php echo e($fileUrl); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                            <img src="<?php echo e($fileUrl); ?>" alt="Attachment Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                            <?php elseif($extension === 'pdf'): ?>
                             <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="<?php echo e(route('feedback.download', $fileName)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="<?php echo e(route('feedback.download', $fileName)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                                <iframe src="<?php echo e(route('feedback.download', $fileName)); ?>" width="100%" height="400px" class="border rounded mt-2"></iframe>
                            <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                             <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="<?php echo e(route('feedback.download', $fileName)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="<?php echo e(route('feedback.download', $fileName)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                                <iframe 
                                    src="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo e(urlencode(route('feedback.download', $fileName))); ?>" 
                                    width="100%" height="400px" class="border rounded mt-2" frameborder="0">
                                </iframe>
                            <?php else: ?>
                                <p class="text-muted">Preview not available for this file type.</p>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> <?php echo e(__('Update Feedback')); ?>

                    </button>
                </div>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>

    
    <?php if($feedback->admin_response): ?>
        <div class="col-md-8 mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><?php echo e(__('Admin Response')); ?></h6>
                </div>
                <div class="card-body">
                    <p><?php echo nl2br(e($feedback->admin_response)); ?></p>
                    <p class="text-muted">
                        <small><?php echo e(__('Responded At')); ?>: <?php echo e($feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A'); ?></small>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Write your feedback...'
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\edit.blade.php ENDPATH**/ ?>