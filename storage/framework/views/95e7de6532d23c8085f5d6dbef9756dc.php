

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Feedback Details')); ?>

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
    <a href="<?php echo e(route('feedback.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Create Feedback">
        <i class="ti ti-plus"></i>
    </a>
    <?php if (app('laratrust')->hasPermission('feedback edit')) : ?>
    <a href="<?php echo e(route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt( $feedback->id))); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit Feedback">
        <i class="ti ti-pencil"></i>
    </a>
   <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5><?php echo e($feedback->title ?? __('No Title')); ?></h5><br>
                <span class="badge bg-info text-white"><?php echo e(ucfirst($feedback->type)); ?></span>
                <span class="badge bg-secondary"><?php echo e(ucfirst($feedback->category)); ?></span>
                <span class="badge bg-<?php echo e($feedback->status === 'resolved' ? 'success' : ($feedback->status === 'reviewed' ? 'warning' : 'danger')); ?>">
                    <?php echo e(ucfirst($feedback->status)); ?>

                </span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1"><strong><?php echo e(__('Submitted By')); ?>:</strong>
                    <?php if($feedback->is_anonymous): ?>
                        <em><?php echo e(__('Anonymous')); ?></em>
                    <?php else: ?>
                        <?php echo e($feedback->name ?? 'N/A'); ?> (<?php echo e($feedback->email ?? 'No Email'); ?>)
                    <?php endif; ?>
                </p>

                <p class="mb-1"><strong><?php echo e(__('Branch')); ?>:</strong> <?php echo e(optional($feedback->branch)->name ?? 'N/A'); ?></p>
                <p class="mb-1"><strong><?php echo e(__('Department')); ?>:</strong> <?php echo e(optional($feedback->department)->name ?? 'N/A'); ?></p>
                <p class="mb-1"><strong><?php echo e(__('Submitted At')); ?>:</strong> <?php echo e($feedback->created_at->format('d M Y h:i A')); ?></p>
                 <hr>
                    <?php echo e(Form::label('message', __('Message :'))); ?>

                    <pre class="form-control" style="min-height: 160px; background-color: #fff; border-left: 5px solid #ccc;">
                        <?php echo $feedback->message; ?>

                    </pre>
                </div>

                <hr>

                 </div>
       

      
      
    </div>   </div>

    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><?php echo e(__('Meta Information')); ?></h6>
            </div>
            <div class="card-body">
                <p><strong><?php echo e(__('Workspace')); ?>:</strong> <?php echo e(optional($feedback->workspace)->name ?? 'N/A'); ?></p>
                <p><strong><?php echo e(__('Status')); ?>:</strong> <?php echo e(ucfirst($feedback->status)); ?></p>
                <p><strong><?php echo e(__('Reviewed By')); ?>:</strong> <?php echo e($feedback->reviewed_at ?? 'Not yet reviewed'); ?></p>
                  
                <div class="card-header bg-light">
                    <h6 class="mb-0"><?php echo e(__('Admin Response :')); ?></h6>
                </div>
                <pre class="form-control" style="min-height: 60px; background-color: #fff; border-left: 5px solid #ccc;">
                    <?php echo nl2br($feedback->admin_response ?? 'Not Response yet'); ?>

                </pre>
                <p class="text-muted">
                    <small><?php echo e(__('Responded At')); ?>: <?php echo e($feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A'); ?></small>
                </p>
              <hr>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js')); ?>"></script>
    <script>
        $(document).on('click', '#file', function() {
            $('#blah').removeClass('d-none');
        });

        $(document).on('change', '.select_person_email', function () {
            let userId = $(this).val();
            $.post('<?php echo e(route('helpdesk-tickets.getuser')); ?>', {
                user_id: userId,
                _token: '<?php echo e(csrf_token()); ?>'
            }, function (data) {
                if (data.email) {
                    $('.emailAddressField').val(data.email).prop('readonly', true).css('background-color', '#e9ecef');
                } else {
                    $('.emailAddressField').val('').prop('readonly', false).css('background-color', '');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\show.blade.php ENDPATH**/ ?>