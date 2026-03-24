<?php $__env->startSection('page-title', __('Households')); ?>
<?php $__env->startSection('page-breadcrumb', __('Household Directory')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('members.index')); ?>" class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to members')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h6 class="mb-0"><?php echo e(__('Create Household')); ?></h6>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('churchly.households.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-2">
                        <label class="form-label"><?php echo e(__('Household name')); ?></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><?php echo e(__('Primary contact (optional)')); ?></label>
                        <input type="number" name="primary_contact_id" class="form-control" placeholder="<?php echo e(__('Member ID')); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><?php echo e(__('Phone')); ?></label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><?php echo e(__('Email')); ?></label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label"><?php echo e(__('Address')); ?></label>
                        <input type="text" name="address_line1" class="form-control mb-2" placeholder="<?php echo e(__('Address line 1')); ?>">
                        <input type="text" name="address_line2" class="form-control mb-2" placeholder="<?php echo e(__('Address line 2')); ?>">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control" placeholder="<?php echo e(__('City')); ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="state" class="form-control" placeholder="<?php echo e(__('State')); ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="postal_code" class="form-control" placeholder="<?php echo e(__('Postal code')); ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="country" class="form-control" placeholder="<?php echo e(__('Country code')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('Notes')); ?></label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary"><?php echo e(__('Save household')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h6 class="mb-0"><?php echo e(__('Existing households')); ?></h6>
            </div>
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Primary contact')); ?></th>
                            <th><?php echo e(__('Members')); ?></th>
                            <th class="text-end"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $households; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $household): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($household->name); ?></strong>
                                    <?php if($household->phone): ?>
                                        <div class="small text-muted"><?php echo e($household->phone); ?></div>
                                    <?php endif; ?>
                                    <?php if($household->email): ?>
                                        <div class="small text-muted"><?php echo e($household->email); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e(optional($household->primaryContact)->name ?? __('—')); ?>

                                </td>
                                <td>
                                    <?php echo e($household->members->count()); ?>

                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#household-<?php echo e($household->id); ?>">
                                        <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

                                    </button>
                                    <form method="POST" action="<?php echo e(route('churchly.households.destroy', $household->id)); ?>" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo e(__('Delete this household?')); ?>')" type="submit">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="collapse" id="household-<?php echo e($household->id); ?>">
                                <td colspan="4">
                                    <form method="POST" action="<?php echo e(route('churchly.households.update', $household->id)); ?>" class="row g-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo e(__('Name')); ?></label>
                                            <input type="text" name="name" value="<?php echo e($household->name); ?>" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo e(__('Primary contact ID')); ?></label>
<input type="number" name="primary_contact_id" value="<?php echo e($household->primary_contact_id); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label"><?php echo e(__('Phone')); ?></label>
                                            <input type="text" name="phone" value="<?php echo e($household->phone); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><?php echo e(__('Email')); ?></label>
                                            <input type="email" name="email" value="<?php echo e($household->email); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><?php echo e(__('Postal code')); ?></label>
                                            <input type="text" name="postal_code" value="<?php echo e($household->postal_code); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label"><?php echo e(__('Notes')); ?></label>
                                            <textarea name="notes" class="form-control" rows="2"><?php echo e($household->notes); ?></textarea>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary btn-sm"><?php echo e(__('Update')); ?></button>
                                        </div>
                                    </form>
                                    <?php if($household->members->isNotEmpty()): ?>
                                        <hr>
                                        <h6 class="small text-uppercase text-muted"><?php echo e(__('Members')); ?></h6>
                                        <?php $__currentLoopData = $household->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-light text-dark me-1 mb-1">
                                                <?php echo e($member->name); ?>

                                                <?php if($member->pivot && $member->pivot->relationship): ?>
                                                    <span class="text-muted">(<?php echo e($member->pivot->relationship); ?>)</span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted"><?php echo e(__('No households found.')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <?php echo e($households->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\households\index.blade.php ENDPATH**/ ?>