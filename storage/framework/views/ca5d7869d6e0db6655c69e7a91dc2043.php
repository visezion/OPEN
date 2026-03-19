<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve(['workspace' => $workspaceModel] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="portal-page-head">
        <h2 class="portal-page-title"><?php echo e(__('Register as a Church Member')); ?></h2>
        <p class="portal-page-subtitle">
            <?php echo e(__('Complete your details so the leadership team can review and welcome you properly.')); ?>

        </p>
    </div>

    <?php if(session('success')): ?>
        <div class="portal-alert success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="portal-alert error">
            <strong><?php echo e(__('Please correct the following errors:')); ?></strong>
            <ul style="margin: 8px 0 0 18px; padding: 0;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('churchly.self.register.store', $workspace)); ?>" enctype="multipart/form-data" class="portal-form">
        <?php echo csrf_field(); ?>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Full Name')); ?></label>
                <input type="text" name="name" class="portal-input" value="<?php echo e(old('name')); ?>" required placeholder="<?php echo e(__('Enter full name')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Email Address')); ?></label>
                <input type="email" name="email" class="portal-input" value="<?php echo e(old('email')); ?>" required placeholder="<?php echo e(__('Enter email address')); ?>">
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Phone Number')); ?></label>
                <input type="text" name="phone" class="portal-input" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo e(__('Enter phone number')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Date of Birth')); ?></label>
                <input type="date" name="dob" class="portal-input" value="<?php echo e(old('dob')); ?>" max="<?php echo e(date('Y-m-d')); ?>">
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Gender')); ?></label>
                <select name="gender" class="portal-select" required>
                    <option value=""><?php echo e(__('Select gender')); ?></option>
                    <option value="Male" <?php if(old('gender') === 'Male'): echo 'selected'; endif; ?>><?php echo e(__('Male')); ?></option>
                    <option value="Female" <?php if(old('gender') === 'Female'): echo 'selected'; endif; ?>><?php echo e(__('Female')); ?></option>
                    <option value="Other" <?php if(old('gender') === 'Other'): echo 'selected'; endif; ?>><?php echo e(__('Other')); ?></option>
                </select>
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Church Branch')); ?></label>
                <select name="branch_id" class="portal-select" required>
                    <option value=""><?php echo e(__('Select branch')); ?></option>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php if((string) old('branch_id') === (string) $id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Department (optional)')); ?></label>
                <select name="department_id" class="portal-select">
                    <option value=""><?php echo e(__('Select department')); ?></option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php if((string) old('department_id') === (string) $id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Designation (optional)')); ?></label>
                <select name="designation_id" class="portal-select">
                    <option value=""><?php echo e(__('Select designation')); ?></option>
                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php if((string) old('designation_id') === (string) $id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Church Date of Joining')); ?></label>
                <input type="date" name="church_doj" class="portal-input" value="<?php echo e(old('church_doj')); ?>" max="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Password')); ?></label>
                <input type="password" name="password" class="portal-input" placeholder="<?php echo e(__('Create password (min 6)')); ?>">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label"><?php echo e(__('Address')); ?></label>
            <textarea name="address" rows="3" class="portal-textarea" placeholder="<?php echo e(__('Enter address')); ?>"><?php echo e(old('address')); ?></textarea>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Emergency Contact Name')); ?></label>
                <input type="text" name="emergency_contact" class="portal-input" value="<?php echo e(old('emergency_contact')); ?>" required placeholder="<?php echo e(__('Enter emergency contact name')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Emergency Contact Phone')); ?></label>
                <input type="text" name="emergency_phone" class="portal-input" value="<?php echo e(old('emergency_phone')); ?>" required placeholder="<?php echo e(__('Enter emergency contact phone')); ?>">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label"><?php echo e(__('Upload Document (optional)')); ?></label>
            <input type="file" name="documents" class="portal-file-input">
        </div>

        <input type="hidden" name="is_active" value="0">

        <button type="submit" class="portal-submit"><?php echo e(__('Submit Registration')); ?></button>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/members/self-register.blade.php ENDPATH**/ ?>