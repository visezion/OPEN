

<?php $__env->startSection('page-title', __('Birthday Templates')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadTemplateModal">
        <i class="ti ti-upload"></i> <?php echo e(__('Upload New Template')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3"><?php echo e(__('Available Templates')); ?></h5>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($templates->count()): ?>
            <div class="row">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <img src="<?php echo e(asset('storage/'.$template->file_path)); ?>" 
                                 class="card-img-top" 
                                 style="height:250px;object-fit:cover;">

                            <div class="card-body text-center">
                                <p class="mb-2"><strong><?php echo e($template->name); ?></strong></p>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($template->is_active): ?>
                                    <span class="badge bg-success mb-2"><?php echo e(__('Active')); ?></span>
                                <?php else: ?>
                                    <form action="<?php echo e(route('birthday_templates.activate', $template->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="ti ti-check"></i> <?php echo e(__('Activate')); ?>

                                        </button>
                                    </form>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="<?php echo e(route('birthday_templates.edit', $template->id)); ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

                                    </a>

                                    <!-- Delete Button -->
                                    <form action="<?php echo e(route('birthday_templates.destroy', $template->id)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this template?')); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i> <?php echo e(__('Delete')); ?>

                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-muted"><?php echo e(__('No templates uploaded yet.')); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadTemplateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo e(route('birthday_templates.store')); ?>" method="POST" enctype="multipart/form-data" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('Upload Birthday Template')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label"><?php echo e(__('Template Name')); ?></label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label"><?php echo e(__('Template File (PNG/JPG)')); ?></label>
                    <input type="file" name="file" id="file" class="form-control" accept="image/*" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo e(__('Upload')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\birthday_templates\index.blade.php ENDPATH**/ ?>