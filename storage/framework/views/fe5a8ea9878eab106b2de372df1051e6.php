

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Custom Member Fields')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFieldModal">
        <i class="ti ti-plus"></i> <?php echo e(__('Add Field')); ?>

    </button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-2">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="col-sm-7">
        
        <div class="card">
            <div class="card-body">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo e(__('Order')); ?></th>
                            <th><?php echo e(__('Key')); ?></th>
                            <th><?php echo e(__('Label')); ?></th>
                            <th><?php echo e(__('Type')); ?></th>
                            <th><?php echo e(__('Default Value')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($field->order); ?></td>
                                <td><code><?php echo e($field->field_key); ?></code></td>
                                <td><?php echo e($field->field_label); ?></td>
                                <td><?php echo e(ucfirst($field->field_type)); ?></td>
                                <td><?php echo e($field->field_value); ?></td>
                                <td>
                                    <a href="<?php echo e(route('formsetup.edit', $field->id)); ?>" class="btn btn-sm btn-warning"><?php echo e(__('Edit')); ?></a>
                                    <form action="<?php echo e(route('formsetup.destroy', $field->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this field?')"><?php echo e(__('Delete')); ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center"><?php echo e(__('No fields found')); ?></td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-sm-3">
        <div class="card p-3">
            <h6 class="mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('What Are Custom Member Fields?')); ?></h6>
            <p class="small text-muted">
                <?php echo e(__('Custom fields allow you to extend the standard member form with additional inputs that suit your church needs. For example, you can collect emergency contacts, baptism dates, or ministry preferences.')); ?>

            </p>

            <h6 class="mt-3"><?php echo e(__('Field Properties Explained')); ?></h6>
            <ul class="small text-muted ps-3">
                <li><strong><?php echo e(__('Field Key')); ?>:</strong> <?php echo e(__('A unique identifier used internally (e.g., "emergency_phone"). Keep it lowercase and without spaces.')); ?></li>
                <li><strong><?php echo e(__('Field Label')); ?>:</strong> <?php echo e(__('The name shown on the member form (e.g., "Emergency Phone").')); ?></li>
                <li><strong><?php echo e(__('Type')); ?>:</strong> <?php echo e(__('Choose how members will enter data: text, textarea, date, dropdown, file upload, or checkbox.')); ?></li>
                <li><strong><?php echo e(__('Default Value')); ?>:</strong> <?php echo e(__('Pre-fill options or values. For dropdowns/checkboxes, separate multiple options with commas (e.g., "Yes,No,Maybe").')); ?></li>
                <li><strong><?php echo e(__('Order')); ?>:</strong> <?php echo e(__('Controls the display sequence of fields on the form. Lower numbers appear first.')); ?></li>
            </ul>

            <h6 class="mt-3"><?php echo e(__('Best Practices')); ?></h6>
            <ul class="small text-muted ps-3">
                <li><?php echo e(__('Always use clear labels so members know what to enter.')); ?></li>
                <li><?php echo e(__('Keep field keys consistent (no spaces, use underscores).')); ?></li>
                <li><?php echo e(__('Avoid adding too many fields at once — keep the form simple and relevant.')); ?></li>
                <li><?php echo e(__('Test new fields by previewing the member registration form.')); ?></li>
            </ul>

            <p class="small text-muted mt-2">
                <?php echo e(__('💡 Tip: Use dropdowns for controlled choices, checkboxes for multiple selections, and file uploads for documents like ID scans or certificates.')); ?>

            </p>
        </div>
    </div>
</div>

<!-- Add Field Modal -->
<div class="modal fade" id="addFieldModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="<?php echo e(route('formsetup.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('Add Custom Field')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label><?php echo e(__('Field Key')); ?></label>
                    <input type="text" name="field_key" class="form-control" placeholder="e.g., emergency_contact" required>
                </div>
                <div class="mb-3">
                    <label><?php echo e(__('Field Label')); ?></label>
                    <input type="text" name="field_label" class="form-control" placeholder="e.g., Emergency Contact" required>
                </div>
                <div class="mb-3">
                    <label><?php echo e(__('Field Type')); ?></label>
                    <select name="field_type" class="form-control" required>
                        <option value="text"><?php echo e(__('Text')); ?></option>
                        <option value="textarea"><?php echo e(__('Textarea')); ?></option>
                        <option value="date"><?php echo e(__('Date')); ?></option>
                        <option value="dropdown"><?php echo e(__('Dropdown')); ?></option>
                        <option value="file"><?php echo e(__('File Upload')); ?></option>
                        <option value="checkbox"><?php echo e(__('Checkbox')); ?></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label><?php echo e(__('Default Value (Optional)')); ?></label>
                    <input type="text" name="field_value" class="form-control" placeholder="e.g., Yes,No,Maybe">
                </div>
                <div class="mb-3">
                    <label><?php echo e(__('Display Order')); ?></label>
                    <input type="number" name="order" class="form-control" value="0" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\setup\formsetup.blade.php ENDPATH**/ ?>