<?php
    $isEdit = $volunteer->exists;
    $formRoute = $isEdit
        ? ['churchly.volunteers.update', $volunteer->id]
        : ['churchly.volunteers.store'];
    $formMethod = $isEdit ? 'PUT' : 'POST';
    $statusOptions = [
        'active' => __('Active'),
        'inactive' => __('Inactive'),
        'paused' => __('Paused'),
    ];
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e($isEdit ? __('Edit Volunteer') : __('Add Volunteer')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <a href="<?php echo e(route('churchly.volunteers.index')); ?>"><?php echo e(__('Volunteers')); ?></a> /
    <?php echo e($isEdit ? __('Edit') : __('Create')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.volunteers.index')); ?>"
       class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to list')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <?php echo e($isEdit ? __('Update Volunteer Profile') : __('Create Volunteer Profile')); ?>

                    </h5>
                </div>
                <div class="card-body">
                    <?php echo e(Form::model($volunteer, ['route' => $formRoute, 'method' => $formMethod])); ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <?php echo e(Form::label('church_member_id', __('Link to member record'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('church_member_id', $members, old('church_member_id', $volunteer->church_member_id), ['class' => 'form-select', 'placeholder' => __('Select member (optional)')])); ?>

                            <div class="form-text"><?php echo e(__('Linking a member allows automatic profile sync.')); ?></div>
                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('status', $statusOptions, old('status', $volunteer->status ?? 'active'), ['class' => 'form-select', 'required' => true])); ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('full_name', __('Full name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('full_name', old('full_name', $volunteer->full_name), ['class' => 'form-control', 'placeholder' => __('John Doe')])); ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('preferred_name', __('Preferred name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('preferred_name', old('preferred_name', $volunteer->preferred_name), ['class' => 'form-control', 'placeholder' => __('Display name used in schedules')])); ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::email('email', old('email', $volunteer->email), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('phone', __('Phone'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('phone', old('phone', $volunteer->phone), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-md-6">
                            <?php echo e(Form::label('joined_at', __('Start serving date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('joined_at', old('joined_at', optional($volunteer->joined_at)->format('Y-m-d')), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-12">
                            <?php echo e(Form::label('departments', __('Departments / Teams'), ['class' => 'form-label'])); ?>

                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col">
                                        <div class="border rounded px-3 py-2">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="dept-<?php echo e($id); ?>"
                                                       name="departments[]"
                                                       value="<?php echo e($id); ?>"
                                                       <?php if(in_array($id, $selectedDepartments)): echo 'checked'; endif; ?>>
                                                <label class="form-check-label" for="dept-<?php echo e($id); ?>">
                                                    <?php echo e($name); ?>

                                                </label>
                                            </div>
                                            <div class="mt-2 ms-4">
                                                <input type="radio"
                                                       name="primary_department"
                                                       value="<?php echo e($id); ?>"
                                                       id="dept-primary-<?php echo e($id); ?>"
                                                       class="form-check-input"
                                                       <?php if($primaryDepartment === $id): echo 'checked'; endif; ?>>
                                                <label for="dept-primary-<?php echo e($id); ?>" class="small form-check-label text-muted">
                                                    <?php echo e(__('Set as primary team')); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-text"><?php echo e(__('Select one or more teams this volunteer belongs to.')); ?></div>
                        </div>
                        <div class="col-12">
                            <?php echo e(Form::label('skills', __('Skills'), ['class' => 'form-label'])); ?>

                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $level = $selectedSkills[$skill->id] ?? 'intermediate';
                                    ?>
                                    <div class="col">
                                        <div class="border rounded px-3 py-2 h-100">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input type="checkbox"
                                                           class="form-check-input"
                                                           id="skill-<?php echo e($skill->id); ?>"
                                                           name="skills[]"
                                                           value="<?php echo e($skill->id); ?>"
                                                           <?php if(array_key_exists($skill->id, $selectedSkills)): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="skill-<?php echo e($skill->id); ?>">
                                                        <?php echo e($skill->name); ?>

                                                    </label>
                                                </div>
                                                <select name="skill_levels[<?php echo e($skill->id); ?>]"
                                                        class="form-select form-select-sm ms-2"
                                                        aria-label="<?php echo e(__('Proficiency level')); ?>">
                                                    <option value="beginner" <?php if($level === 'beginner'): echo 'selected'; endif; ?>><?php echo e(__('Beginner')); ?></option>
                                                    <option value="intermediate" <?php if($level === 'intermediate'): echo 'selected'; endif; ?>><?php echo e(__('Intermediate')); ?></option>
                                                    <option value="advanced" <?php if($level === 'advanced'): echo 'selected'; endif; ?>><?php echo e(__('Advanced')); ?></option>
                                                    <option value="expert" <?php if($level === 'expert'): echo 'selected'; endif; ?>><?php echo e(__('Expert')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-text"><?php echo e(__('Tick the skills that apply and set proficiency level if needed.')); ?></div>
                        </div>
                        <div class="col-12">
                            <?php echo e(Form::label('new_skills_text', __('Add new skills'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::textarea('new_skills_text', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter new skills separated by commas')])); ?>

                        </div>
                        <div class="col-12">
                            <?php echo e(Form::label('notes', __('Internal notes'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::textarea('notes', old('notes', $volunteer->notes), ['class' => 'form-control', 'rows' => 3])); ?>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?php echo e(route('churchly.volunteers.index')); ?>" class="btn btn-light"><?php echo e(__('Cancel')); ?></a>
                        <button type="submit" class="btn btn-primary">
                            <?php echo e($isEdit ? __('Save changes') : __('Create volunteer')); ?>

                        </button>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\volunteers\form.blade.php ENDPATH**/ ?>