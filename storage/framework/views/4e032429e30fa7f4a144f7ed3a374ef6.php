

<?php $__env->startSection('page-title', __('Edit Church Member')); ?>
<?php $__env->startSection('page-breadcrumb', __('Church Member')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <?php echo e(Form::model($member, [
                    'route' => ['churchly.members.update', $member->id],
                    'method' => 'PUT',
                    'class' => 'needs-validation',
                    'novalidate',
                    'id' => 'member-details-form',
                    'enctype' => 'multipart/form-data'
                ])); ?>


                <div class="row">
                    
                    <div class="col-md-3">
                        <h5><?php echo e(__('Personal Details')); ?></h5>
                        <hr>
                        <div class="form-group mb-3 text-center">
                            <label class="form-label d-block"><?php echo e(__('Profile Photo')); ?></label>
                            <div class="mb-3">
                                <img id="preview-image" 
                                    src="<?php echo e($member->profile_photo ? asset('storage/'.$member->profile_photo) : 'https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/profle-512.png'); ?>" 
                                    alt="Profile Preview" 
                                    class="rounded-circle border" 
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" hidden>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('profile-photo-input').click()">
                                <i class="ti ti-upload"></i> <?php echo e(__('Change Photo')); ?>

                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetProfilePhoto()">
                                <i class="ti ti-trash"></i> <?php echo e(__('Remove')); ?>

                            </button>
                        </div>

                        <div class="form-group mb-3">
                            <?php echo e(Form::label('name', __('Full Name'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::text('name', $member->name, ['class' => 'form-control', 'required'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('email', __('Email'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::email('email', $member->email, ['class' => 'form-control', 'required'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('phone', __('Phone'))); ?>

                            <?php echo e(Form::text('phone', $member->phone, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('dob', __('Date of Birth'))); ?>

                            <?php echo e(Form::date('dob', $member->dob, ['class' => 'form-control', 'max' => date('Y-m-d')])); ?>

                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <h5><?php echo e(__('Personal Information & Emergency')); ?></h5>
                        <hr>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('gender', __('Gender'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::select('gender', ['Male'=>'Male','Female'=>'Female','Other'=>'Other'], $member->gender, ['class'=>'form-control','required'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('address', __('Address'))); ?>

                            <?php echo e(Form::textarea('address', $member->address, ['class'=>'form-control','rows'=>2])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('emergency_contact', __('Emergency Contact Name'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::text('emergency_contact', $member->emergency_contact, ['class'=>'form-control','required'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('emergency_phone', __('Emergency Contact Phone'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::text('emergency_phone', $member->emergency_phone, ['class'=>'form-control','required'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('family_id', __('Family Group'))); ?>

                            <?php echo e(Form::select('family_id', $members, $member->family_id, ['class'=>'form-control','placeholder'=>'Select Family Head'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('spouse_id', __('Spouse'))); ?>

                            <?php echo e(Form::select('spouse_id', $members, $member->spouse_id, ['class'=>'form-control','placeholder'=>'Select Spouse'])); ?>

                        </div>
                    </div>

                    
                    <div class="col-md-5">
                        <h5><?php echo e(__('Church Details')); ?></h5>
                        <hr>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('membership_status', __('Membership Status'))); ?>

                            <?php echo e(Form::select('membership_status', ['Active'=>'Active','Inactive'=>'Inactive','Visitor'=>'Visitor','New Convert'=>'New Convert'], $member->membership_status, ['class'=>'form-control'])); ?>

                        </div>

                        
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('branch_id', __('Branch'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::select('branch_id', $branches, $member->branch_id, ['class'=>'form-control','id'=>'branch-select','required','placeholder'=>'Select Branch'])); ?>

                        </div>

                        
                        <div class="form-group mb-3">
                            <label><?php echo e(__('Departments & Designations')); ?></label>
                            <div id="departments-wrapper">
                                <?php $i = 0; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $member->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="row mb-2 department-row">
                                        <div class="col-md-5">
                                            <select name="departments[<?php echo e($i); ?>][department_id]" class="form-control department-select" data-index="<?php echo e($i); ?>">
                                                <option value=""><?php echo e(__('Select Department (optional)')); ?></option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>" <?php echo e($dept->id == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="departments[<?php echo e($i); ?>][designation_id]" class="form-control designation-select" data-index="<?php echo e($i); ?>">
                                                <option value=""><?php echo e(__('Select Designation (optional)')); ?></option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>" <?php echo e($dept->pivot->designation_id == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-row">&times;</button>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="row mb-2 department-row">
                                        <div class="col-md-6">
                                            <select name="departments[0][department_id]" class="form-control department-select" data-index="0">
                                                <option value=""><?php echo e(__('Select Department (optional)')); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="departments[0][designation_id]" class="form-control designation-select" data-index="0">
                                                <option value=""><?php echo e(__('Select Designation (optional)')); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-row">&times;</button>
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <button type="button" id="add-department" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="ti ti-plus"></i> <?php echo e(__('Add Another Department')); ?>

                            </button>
                        </div>

                        <div class="form-group mb-3">
                            <?php echo e(Form::label('role', __('Role'))); ?><?php if (isset($component)) { $__componentOriginalbba606fec37ea04333bc269e3e165587 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbba606fec37ea04333bc269e3e165587 = $attributes; } ?>
<?php $component = App\View\Components\Required::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Required::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $attributes = $__attributesOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__attributesOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbba606fec37ea04333bc269e3e165587)): ?>
<?php $component = $__componentOriginalbba606fec37ea04333bc269e3e165587; ?>
<?php unset($__componentOriginalbba606fec37ea04333bc269e3e165587); ?>
<?php endif; ?>
                            <?php echo e(Form::select('role', $role, optional($member->user->roles->first())->id, ['class'=>'form-control','required','placeholder'=>'Select Role'])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('church_doj', __('Date of Joining'))); ?>

                            <?php echo e(Form::date('church_doj', $member->church_doj, ['class'=>'form-control','max'=>date('Y-m-d')])); ?>

                        </div>
                        <div class="form-group mb-3">
                            <?php echo e(Form::label('is_active', __('Account Status'))); ?>

                            <?php echo e(Form::select('is_active', ['1'=>'Active','0'=>'Inactive'], $member->is_active, ['class'=>'form-control'])); ?>

                        </div>
                    </div>

                    
                    <div class="col-12 mt-4">
                        <h5><?php echo e(__('Additional Information')); ?></h5>
                        <hr>
                        <div class="row">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $value = $member->customValues->where('field_key', $field->field_key)->first()->field_value ?? null;
                                ?>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><?php echo e($field->field_label); ?></label>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->field_type == 'text'): ?>
                                        <?php echo e(Form::text("custom[{$field->field_key}]", $value, ['class'=>'form-control'])); ?>

                                    <?php elseif($field->field_type == 'textarea'): ?>
                                        <?php echo e(Form::textarea("custom[{$field->field_key}]", $value, ['class'=>'form-control','rows'=>2])); ?>

                                    <?php elseif($field->field_type == 'date'): ?>
                                        <?php echo e(Form::date("custom[{$field->field_key}]", $value, ['class'=>'form-control'])); ?>

                                    <?php elseif($field->field_type == 'file'): ?>
                                        <?php echo e(Form::file("custom[{$field->field_key}]", ['class'=>'form-control'])); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($value): ?>
                                            <a href="<?php echo e(asset('storage/'.$value)); ?>" target="_blank"><?php echo e(__('View File')); ?></a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php elseif($field->field_type == 'dropdown'): ?>
                                        <select name="custom[<?php echo e($field->field_key); ?>]" class="form-control">
                                            <option value=""><?php echo e(__('-- Select --')); ?></option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = explode(',', $field->field_value); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e(trim($opt)); ?>" <?php echo e($value == trim($opt) ? 'selected' : ''); ?>><?php echo e(trim($opt)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    <?php elseif($field->field_type == 'checkbox'): ?>
                                        <div class="form-check">
                                            <input type="checkbox" name="custom[<?php echo e($field->field_key); ?>]" value="1" class="form-check-input" <?php echo e($value ? 'checked' : ''); ?>>
                                            <label class="form-check-label"><?php echo e($field->field_label); ?></label>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo e(route('churchly.members.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Update Member')); ?></button>
                </div>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const getDepartmentsUrl = "<?php echo e(route('departments.byBranch')); ?>";
    const getDesignationsUrl = "<?php echo e(route('designations.byDepartment')); ?>";

    document.addEventListener('DOMContentLoaded', function () {
        let index = <?php echo e($member->departments->count() ?: 1); ?>;
        const branchSelect = document.getElementById('branch-select');

        // Add department row
        document.getElementById('add-department').addEventListener('click', function () {
            let wrapper = document.getElementById('departments-wrapper');
            let newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2', 'department-row');

            newRow.innerHTML = `
                <div class="col-md-5">
                    <select name="departments[${index}][department_id]" class="form-control department-select" data-index="${index}">
                        <option value=""><?php echo e(__('Select Department (optional)')); ?></option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="departments[${index}][designation_id]" class="form-control designation-select" data-index="${index}">
                        <option value=""><?php echo e(__('Select Designation (optional)')); ?></option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-row">&times;</button>
                </div>
            `;
            wrapper.appendChild(newRow);

            if (branchSelect.value) {
                fetchDepartments(branchSelect.value, index);
            }
            index++;
        });

        // Remove row
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.department-row').remove();
            }
        });

        // Branch change → reload departments
        branchSelect.addEventListener('change', function () {
            let branchId = this.value;
            document.querySelectorAll('.department-select').forEach(deptSelect => {
                let idx = deptSelect.dataset.index;
                fetchDepartments(branchId, idx);
            });
        });

        // Department change → load designations
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('department-select')) {
                let deptId = e.target.value;
                let idx = e.target.dataset.index;
                fetchDesignations(deptId, idx);
            }
        });

        function fetchDepartments(branchId, idx) {
            let deptSelect = document.querySelector(`select[name="departments[${idx}][department_id]"]`);
            let desigSelect = document.querySelector(`select[name="departments[${idx}][designation_id]"]`);
            deptSelect.innerHTML = '<option value=""><?php echo e(__("Select Department (optional)")); ?></option>';
            desigSelect.innerHTML = '<option value=""><?php echo e(__("Select Designation (optional)")); ?></option>';

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        deptSelect.appendChild(option);
                    });
                });
        }

        function fetchDesignations(deptId, idx) {
            let desigSelect = document.querySelector(`select[name="departments[${idx}][designation_id]"]`);
            desigSelect.innerHTML = '<option value=""><?php echo e(__("Select Designation (optional)")); ?></option>';

            if (!deptId) return;

            fetch(`${getDesignationsUrl}?department=${deptId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        desigSelect.appendChild(option);
                    });
                });
        }
    });

    // Profile photo preview/reset
    const input = document.getElementById('profile-photo-input');
    const preview = document.getElementById('preview-image');
    const defaultImage = "<?php echo e(asset('images/default-avatar.png')); ?>";

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function resetProfilePhoto() {
        input.value = '';
        preview.src = defaultImage;
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\edit.blade.php ENDPATH**/ ?>