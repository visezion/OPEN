

<?php $__env->startSection('page-title', __('Church Document Types')); ?>
<?php $__env->startSection('page-breadcrumb', __('Church Document Types')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <h5 class="mb-0"><?php echo e(__('Church Document Types')); ?></h5>
            <a href="<?php echo e(route('church.document_types.create')); ?>" class="btn btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('Add Document Type')); ?>

            </a>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo e(__('ID')); ?></th>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Is Required')); ?></th>
                            <th><?php echo e(__('Created At')); ?></th>
                            <th><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $documentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($doc->id); ?></td>
                                <td><?php echo e($doc->name); ?></td>
                                <td><?php echo e($doc->is_required ? __('Yes') : __('No')); ?></td>
                                <td><?php echo e(company_date_formate($doc->created_at)); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo e(route('church.document_types.edit', $doc->id)); ?>" class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i> <?php echo e(__('Edit')); ?>

                                        </a>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['church.document_types.destroy', $doc->id], 'style'=>'display:inline']); ?>

                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('<?php echo e(__('Are you sure?')); ?>')">
                                                <i class="ti ti-trash"></i> <?php echo e(__('Delete')); ?>

                                            </button>
                                        <?php echo Form::close(); ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentTypes->isEmpty()): ?>
                            <tr>
                                <td colspan="5" class="text-center"><?php echo e(__('No document types found.')); ?></td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($documentTypes->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\document_types\index.blade.php ENDPATH**/ ?>