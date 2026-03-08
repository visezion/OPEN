<?php $__env->startSection('page-title'); ?>
    <?php echo e($volunteer->display_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <a href="<?php echo e(route('churchly.volunteers.index')); ?>"><?php echo e(__('Volunteers')); ?></a> /
    <?php echo e($volunteer->display_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <?php if (app('laratrust')->hasPermission('church_volunteer manage')) : ?>
            <a href="<?php echo e(route('churchly.volunteers.edit', $volunteer)); ?>"
               class="btn btn-sm btn-primary">
                <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

            </a>
        <?php endif; // app('laratrust')->permission ?>
        <?php if (app('laratrust')->hasPermission('church_volunteer manage')) : ?>
            <?php echo Form::open(['route' => ['churchly.volunteers.destroy', $volunteer], 'method' => 'DELETE', 'class' => 'd-inline']); ?>

                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('<?php echo e(__('Delete this volunteer profile?')); ?>');">
                    <i class="ti ti-trash"></i> <?php echo e(__('Delete')); ?>

                </button>
            <?php echo Form::close(); ?>

        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-4">
                        <div class="flex-grow-1">
                            <h4 class="mb-1"><?php echo e($volunteer->display_name); ?></h4>
                            <div class="mb-2">
                                <span class="badge bg-success me-2"><?php echo e(ucfirst($volunteer->status)); ?></span>
                                <?php if($volunteer->joined_at): ?>
                                    <span class="text-muted small">
                                        <?php echo e(__('Serving since :date', ['date' => $volunteer->joined_at->format('d M Y')])); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted"><?php echo e(__('Email')); ?></dt>
                                <dd class="col-sm-8"><?php echo e($volunteer->email ?? '—'); ?></dd>

                                <dt class="col-sm-4 text-muted"><?php echo e(__('Phone')); ?></dt>
                                <dd class="col-sm-8"><?php echo e($volunteer->phone ?? '—'); ?></dd>

                                <dt class="col-sm-4 text-muted"><?php echo e(__('Linked member')); ?></dt>
                                <dd class="col-sm-8">
                                    <?php if($volunteer->member): ?>
                                        <a href="<?php echo e(route('members.show', $volunteer->member->id)); ?>">
                                            <?php echo e($volunteer->member->name); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo e(__('Not linked')); ?></span>
                                    <?php endif; ?>
                                </dd>

                                <dt class="col-sm-4 text-muted"><?php echo e(__('Primary team')); ?></dt>
                                <dd class="col-sm-8">
                                    <?php echo e(optional($volunteer->primary_department)->name ?? __('Unset')); ?>

                                </dd>
                            </dl>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small"><?php echo e(__('Departments')); ?></h6>
                            <div class="mb-3">
                                <?php $__empty_1 = true; $__currentLoopData = $volunteer->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <span class="badge bg-light text-dark me-1 mb-1">
                                        <?php echo e($department->name); ?>

                                        <?php if(data_get($department, 'pivot.is_primary')): ?>
                                            <span class="text-success ms-1"><?php echo e(__('Primary')); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="text-muted"><?php echo e(__('No departments assigned yet.')); ?></span>
                                <?php endif; ?>
                            </div>
                            <h6 class="text-muted text-uppercase small"><?php echo e(__('Skills')); ?></h6>
                            <div>
                                <?php $__empty_1 = true; $__currentLoopData = $volunteer->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <span class="badge bg-secondary me-1 mb-1">
                                        <?php echo e($skill->name); ?>

                                        <span class="ms-1 small">
                                            (<?php echo e(ucfirst($skill->pivot->proficiency ?? 'intermediate')); ?>)
                                        </span>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="text-muted"><?php echo e(__('No skills tagged.')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if($volunteer->notes): ?>
                        <hr>
                        <div>
                            <h6 class="text-muted text-uppercase small"><?php echo e(__('Notes')); ?></h6>
                            <p class="mb-0"><?php echo e($volunteer->notes); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <?php echo $__env->make('churchly::volunteers.partials.assignments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-lg-6">
            <?php echo $__env->make('churchly::volunteers.partials.trainings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="col-lg-6">
            <?php echo $__env->make('churchly::volunteers.partials.availability', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.querySelectorAll('.assignment-form .assignment-type').forEach(function (select) {
            function togglePickers() {
                const wrapper = select.closest('.assignment-form');
                const type = select.value;
                wrapper.querySelectorAll('.assignment-picker').forEach(function (el) {
                    el.classList.add('d-none');
                    const input = el.querySelector('select');
                    if (input) {
                        input.disabled = true;
                    }
                });
                if (type === 'event') {
                    const block = wrapper.querySelector('.assignment-picker-event');
                    if (block) {
                        block.classList.remove('d-none');
                        const input = block.querySelector('select');
                        if (input) {
                            input.disabled = false;
                        }
                    }
                } else if (type === 'attendance_event') {
                    const block = wrapper.querySelector('.assignment-picker-attendance');
                    if (block) {
                        block.classList.remove('d-none');
                        const input = block.querySelector('select');
                        if (input) {
                            input.disabled = false;
                        }
                    }
                }
                const labelField = wrapper.querySelector('.assignment-label-field');
                if (labelField) {
                    labelField.classList.toggle('d-none', type === 'event' || type === 'attendance_event');
                }
            }
            select.addEventListener('change', togglePickers);
            togglePickers();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\show.blade.php ENDPATH**/ ?>