<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?php echo e(__('Availability')); ?></h5>
    </div>
    <div class="card-body">
        <?php echo Form::open(['route' => ['churchly.volunteers.availability.store', $volunteer->id], 'method' => 'POST', 'class' => 'row g-3']); ?>

            <div class="col-md-6">
                <?php echo Form::label('day_of_week', __('Day of week'), ['class' => 'form-label']); ?>

                <?php echo Form::select('day_of_week', [
                    'monday' => __('Monday'),
                    'tuesday' => __('Tuesday'),
                    'wednesday' => __('Wednesday'),
                    'thursday' => __('Thursday'),
                    'friday' => __('Friday'),
                    'saturday' => __('Saturday'),
                    'sunday' => __('Sunday'),
                    'flexible' => __('Flexible'),
                ], null, ['class' => 'form-select', 'required' => true]); ?>

            </div>
            <div class="col-md-3">
                <?php echo Form::label('start_time', __('From'), ['class' => 'form-label']); ?>

                <?php echo Form::time('start_time', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-3">
                <?php echo Form::label('end_time', __('To'), ['class' => 'form-label']); ?>

                <?php echo Form::time('end_time', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('effective_from', __('Effective from'), ['class' => 'form-label']); ?>

                <?php echo Form::date('effective_from', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('effective_until', __('Effective until'), ['class' => 'form-label']); ?>

                <?php echo Form::date('effective_until', null, ['class' => 'form-control']); ?>

            </div>
            <div class="col-md-6">
                <?php echo Form::label('timezone', __('Timezone'), ['class' => 'form-label']); ?>

                <?php echo Form::text('timezone', config('app.timezone'), ['class' => 'form-control']); ?>

            </div>
            <div class="col-12">
                <?php echo Form::label('notes', __('Notes'), ['class' => 'form-label']); ?>

                <?php echo Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2]); ?>

            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-plus"></i> <?php echo e(__('Add availability')); ?>

                </button>
            </div>
        <?php echo Form::close(); ?>

    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th><?php echo e(__('Window')); ?></th>
                    <th><?php echo e(__('Effective dates')); ?></th>
                    <th class="text-end"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $volunteer->availabilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="fw-semibold text-capitalize"><?php echo e(str_replace('_', ' ', $availability->day_of_week)); ?></div>
                            <div class="small text-muted">
                                <?php echo e($availability->start_time ? \Illuminate\Support\Carbon::parse($availability->start_time)->format('H:i') : '—'); ?>

                                —
                                <?php echo e($availability->end_time ? \Illuminate\Support\Carbon::parse($availability->end_time)->format('H:i') : '—'); ?>

                                <?php if($availability->timezone): ?>
                                    <span class="ms-1">(<?php echo e($availability->timezone); ?>)</span>
                                <?php endif; ?>
                            </div>
                            <?php if($availability->notes): ?>
                                <div class="small text-muted mt-1"><?php echo e($availability->notes); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted">
                            <?php echo e(optional($availability->effective_from)->format('d M Y') ?? '—'); ?>

                            <?php if($availability->effective_until): ?>
                                <br><?php echo e(__('Until :date', ['date' => $availability->effective_until->format('d M Y')])); ?>

                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#availability-edit-<?php echo e($availability->id); ?>">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <?php echo Form::open([
                                    'route' => ['churchly.volunteers.availability.destroy', $volunteer->id, $availability->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".__('Remove this availability?')."');"
                                ]); ?>

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                <?php echo Form::close(); ?>

                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="availability-edit-<?php echo e($availability->id); ?>">
                        <td colspan="3">
                            <?php echo Form::model($availability, ['route' => ['churchly.volunteers.availability.update', $volunteer->id, $availability->id], 'method' => 'PUT']); ?>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <?php echo Form::label('day_of_week_'.$availability->id, __('Day of week'), ['class' => 'form-label']); ?>

                                    <?php echo Form::select('day_of_week', [
                                        'monday' => __('Monday'),
                                        'tuesday' => __('Tuesday'),
                                        'wednesday' => __('Wednesday'),
                                        'thursday' => __('Thursday'),
                                        'friday' => __('Friday'),
                                        'saturday' => __('Saturday'),
                                        'sunday' => __('Sunday'),
                                        'flexible' => __('Flexible'),
                                    ], $availability->day_of_week, ['class' => 'form-select']); ?>

                                </div>
                                <div class="col-md-3">
                                    <?php echo Form::label('start_time_'.$availability->id, __('From'), ['class' => 'form-label']); ?>

                                    <?php echo Form::time('start_time', $availability->start_time ? \Illuminate\Support\Str::of($availability->start_time)->substr(0,5) : null, ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-3">
                                    <?php echo Form::label('end_time_'.$availability->id, __('To'), ['class' => 'form-label']); ?>

                                    <?php echo Form::time('end_time', $availability->end_time ? \Illuminate\Support\Str::of($availability->end_time)->substr(0,5) : null, ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('effective_from_'.$availability->id, __('Effective from'), ['class' => 'form-label']); ?>

                                    <?php echo Form::date('effective_from', optional($availability->effective_from)->format('Y-m-d'), ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('effective_until_'.$availability->id, __('Effective until'), ['class' => 'form-label']); ?>

                                    <?php echo Form::date('effective_until', optional($availability->effective_until)->format('Y-m-d'), ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo Form::label('timezone_'.$availability->id, __('Timezone'), ['class' => 'form-label']); ?>

                                    <?php echo Form::text('timezone', $availability->timezone, ['class' => 'form-control']); ?>

                                </div>
                                <div class="col-12">
                                    <?php echo Form::label('notes_'.$availability->id, __('Notes'), ['class' => 'form-label']); ?>

                                    <?php echo Form::textarea('notes', $availability->notes, ['class' => 'form-control', 'rows' => 2]); ?>

                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse" data-bs-target="#availability-edit-<?php echo e($availability->id); ?>"><?php echo e(__('Cancel')); ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4"><?php echo e(__('No availability preferences recorded.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\partials\availability.blade.php ENDPATH**/ ?>