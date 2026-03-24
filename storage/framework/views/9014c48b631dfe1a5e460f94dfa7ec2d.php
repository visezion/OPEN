

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Review Feedback')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Feedbacks')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <a href="<?php echo e(route('feedback.index')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5><?php echo e($feedback->title); ?></h5>
                <span class="badge bg-info text-white"><?php echo e(ucfirst($feedback->type)); ?></span>
                <span class="badge bg-secondary"><?php echo e(ucfirst($feedback->category)); ?></span>
                <span class="badge bg-warning text-dark"><?php echo e(ucfirst($feedback->status)); ?></span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Submitted By:</strong></label>
                    <p>
                        <?php if($feedback->is_anonymous): ?>
                            Anonymous
                        <?php else: ?>
                            <?php echo e($feedback->name); ?> <br>
                            <small><?php echo e($feedback->email); ?></small>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Message:</strong></label>
                    <div class="border p-3 bg-light rounded">
                        <pre class="form-control" style="min-height: 160px; background-color: #fff; border-left: 5px solid #ccc;">
                            <?php echo $feedback->message; ?>

                        </pre>
                    </div>
                </div>

                <div class="mb-3">
                 <?php if($feedback->attachment): ?>
                    <p><strong><?php echo e(__('Attachment')); ?>:</strong></p>
                    <?php
                        $fileUrl = asset('storage/' . $feedback->attachment);
                        $fileName = basename($feedback->attachment);
                        $filePath = storage_path('app/public/' . $feedback->attachment);
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    ?>

                    <div class="mb-2 d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('feedback.download', $fileName)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye"></i> View File
                        </a>
                        <a href="<?php echo e(route('feedback.download', $fileName)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="ti ti-download"></i> Download Attachment
                        </a>
                    </div><br>

                    <?php if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                        <img src="<?php echo e($fileUrl); ?>" alt="Attachment Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                    <?php elseif($extension === 'pdf'): ?>
                        <iframe src="<?php echo e(route('feedback.download', $fileName)); ?>" width="100%" height="400px" class="border rounded mt-2"></iframe>
                    <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                        <iframe 
                            src="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo e(urlencode( route('feedback.download', $fileName))); ?>"
                            width="100%" height="400px" class="border rounded mt-2" frameborder="0">
                        </iframe>
                    <?php else: ?>
                        <p class="text-muted">Preview not available for this file type.</p>
                    <?php endif; ?>
                <?php endif; ?>
        </div>
    </div>  
</div>  
</div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><?php echo e(__('Response to Feedback')); ?></h6>
            </div>
            <div class="card-body">
            <?php if($feedback->admin_response): ?>
            <div class="mb-3">
                <label class="form-label"><strong>Previous Response:</strong></label>
               <pre class="form-control" style="min-height: 60px; background-color: #fff; border-left: 5px solid #ccc;">
                      <?php echo nl2br($feedback->admin_response); ?>

                    </pre>
                    <p class="text-muted">
                        <small><?php echo e(__('Responded At')); ?>: <?php echo e($feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A'); ?></small>
                    </p>
            </div>
            <?php endif; ?>

            <form action="<?php echo e(route('feedback.updateResponse', $feedback->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="admin_response" class="form-label"><strong>Your Response:</strong></label>
                    <textarea name="admin_response" class="form-control summernote" rows="6" required><?php echo e(old('admin_response', $feedback->admin_response)); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label"><strong>Update Status:</strong></label>
                    <select name="status" class="form-select" required>
                        <option value="pending" <?php echo e($feedback->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="reviewed" <?php echo e($feedback->status == 'reviewed' ? 'selected' : ''); ?>>Reviewed</option>
                        <option value="resolved" <?php echo e($feedback->status == 'resolved' ? 'selected' : ''); ?>>Resolved</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Submit Response')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [ ['style', ['bold', 'italic', 'underline']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link']], ['view', ['fullscreen', 'codeview']] ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\review.blade.php ENDPATH**/ ?>