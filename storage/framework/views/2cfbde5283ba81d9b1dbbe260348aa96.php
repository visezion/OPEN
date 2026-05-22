<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?php echo e(__('Training History')); ?></h5>
    </div>
    <div class="card-body">
        <?php echo Form::open(['route' => ['churchly.volunteers.trainings.store', $volunteer->id], 'method' => 'POST', 'class' => 'row g-3']); ?>

            <div class="col-md-6">
                <?php echo Form::label('title', __('Training title'), ['class' => 'form-label']); ?>

                <?php echo Form::text('title', null, ['class' => 'form-control', 'required' => true]); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('provider', __('Provider'), ['class' => 'form-label']); ?>

                <?php echo Form::text('provider', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('completed_on', __('Completed on'), ['class' => 'form-label']); ?>

                <?php echo Form::date('completed_on', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('valid_until', __('Valid until'), ['class' => 'form-label']); ?>

                <?php echo Form::date('valid_until', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('status', __('Status'), ['class' => 'form-label']); ?>

                <?php echo Form::select('status', [
                    'scheduled' => __('Scheduled'),
                    'in_progress' => __('In progress'),
                    'completed' => __('Completed'),
                    'expired' => __('Expired'),
                ], 'completed', ['class' => 'form-select']); ?>

            </div>
            <div class="col-12">
                <?php echo Form::label('notes', __('Notes'), ['class' => 'form-label']); ?>

                <?php echo Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2]); ?>

            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> <?php echo e(__('Add training')); ?>

                </button>
            </div>
        <?php echo Form::close(); ?>

    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th><?php echo e(__('Course')); ?></th>
                    <th><?php echo e(__('Status')); ?></th>
                    <th><?php echo e(__('Completed')); ?></th>
                    <th class="text-end"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $volunteer->trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?php echo e($training->title); ?></div>
                            <div class="small text-muted"><?php echo e($training->provider ?? '—'); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($training->notes): ?>
                                <div class="small text-muted mt-1"><?php echo e($training->notes); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><span class="badge bg-info"><?php echo e(ucfirst(str_replace('_', ' ', $training->status))); ?></span></td>
                        <td class="small text-muted">
                            <?php echo e(optional($training->completed_on)->format('d M Y') ?? '—'); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($training->valid_until): ?>
                                <br><span><?php echo e(__('Valid till :date', ['date' => $training->valid_until->format('d M Y')])); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#training-edit-<?php echo e($training->id); ?>">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <?php echo Form::open([
                                    'route' => ['churchly.volunteers.trainings.destroy', $volunteer->id, $training->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('Remove this training record?')."');"
                                ]); ?>

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                <?php echo Form::close(); ?>

                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="training-edit-<?php echo e($training->id); ?>">
                        <td colspan="4">
                            <?php echo Form::model($training, ['route' => ['churchly.volunteers.trainings.update', $volunteer->id, $training->id], 'method' => 'PUT']); ?>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <?php echo Form::label('title_'.$training->id, __('Training title'), ['class' => 'form-label']); ?>

                                    <?php echo Form::text('title', $training->title, ['class' => 'form-control', 'required' => true]); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('provider_'.$training->id, __('Provider'), ['class' => 'form-label']); ?>

                                    <?php echo Form::text('provider', $training->provider, ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('completed_on_'.$training->id, __('Completed on'), ['class' => 'form-label']); ?>

                                    <?php echo Form::date('completed_on', optional($training->completed_on)->format('Y-m-d'), ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('valid_until_'.$training->id, __('Valid until'), ['class' => 'form-label']); ?>

                                    <?php echo Form::date('valid_until', optional($training->valid_until)->format('Y-m-d'), ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('status_'.$training->id, __('Status'), ['class' => 'form-label']); ?>

                                    <?php echo Form::select('status', [
                                        'scheduled' => __('Scheduled'),
                                        'in_progress' => __('In progress'),
                                        'completed' => __('Completed'),
                                        'expired' => __('Expired'),
                                    ], $training->status, ['class' => 'form-select']); ?>

                                </div>
                                <div class="col-12">
                                    <?php echo Form::label('notes_'.$training->id, __('Notes'), ['class' => 'form-label']); ?>

                                    <?php echo Form::textarea('notes', $training->notes, ['class' => 'form-control', 'rows' => 2]); ?>

                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#training-edit-<?php echo e($training->id); ?>"><?php echo e(__('Cancel')); ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4"><?php echo e(__('No training records yet.')); ?></td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\partials\trainings.blade.php ENDPATH**/ ?>