<?php echo csrf_field(); ?>

<div class="row">

    
    <div class="col-md-12 mb-3">
        <label for="title" class="form-label"><?php echo e(__('Title')); ?></label>
        <input type="text" name="title" id="title" class="form-control"
               value="<?php echo e(old('title', $feedback->title ?? '')); ?>" placeholder="<?php echo e(__('Enter feedback title')); ?>">
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="type" class="form-label"><?php echo e(__('Type')); ?></label>
        <select name="type" id="type" class="form-select" required>
            <option value="internal" <?php echo e(old('type', $feedback->type ?? '') === 'internal' ? 'selected' : ''); ?>><?php echo e(__('Internal')); ?></option>
            <option value="public" <?php echo e(old('type', $feedback->type ?? '') === 'public' ? 'selected' : ''); ?>><?php echo e(__('Public')); ?></option>
        </select>
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="category" class="form-label"><?php echo e(__('Category')); ?></label>
        <select name="category" id="category" class="form-select">
            <?php $__currentLoopData = ['suggestion', 'complaint', 'praise', 'other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat); ?>" <?php echo e(old('category', $feedback->category ?? '') === $cat ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($cat)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="col-md-12 mb-3">
        <label for="message" class="form-label"><?php echo e(__('Message')); ?></label>
        <textarea name="message" id="message" class="form-control" rows="5" required><?php echo e(old('message', $feedback->message ?? '')); ?></textarea>
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="is_anonymous" class="form-label"><?php echo e(__('Is Anonymous?')); ?></label>
        <select name="is_anonymous" id="is_anonymous" class="form-select">
            <option value="0" <?php echo e(old('is_anonymous', $feedback->is_anonymous ?? 0) == 0 ? 'selected' : ''); ?>><?php echo e(__('No')); ?></option>
            <option value="1" <?php echo e(old('is_anonymous', $feedback->is_anonymous ?? 0) == 1 ? 'selected' : ''); ?>><?php echo e(__('Yes')); ?></option>
        </select>
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label"><?php echo e(__('Your Name')); ?></label>
        <input type="text" name="name" id="name" class="form-control"
               value="<?php echo e(old('name', $feedback->name ?? '')); ?>" placeholder="<?php echo e(__('Full Name')); ?>">
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
        <input type="email" name="email" id="email" class="form-control"
               value="<?php echo e(old('email', $feedback->email ?? '')); ?>" placeholder="example@email.com">
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="branch_id" class="form-label"><?php echo e(__('Branch')); ?></label>
        <select name="branch_id" id="branch_id" class="form-select">
            <option value=""><?php echo e(__('Select Branch')); ?></option>
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id', $feedback->branch_id ?? '') == $branch->id ? 'selected' : ''); ?>>
                    <?php echo e($branch->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="col-md-6 mb-3">
        <label for="department_id" class="form-label"><?php echo e(__('Department')); ?></label>
        <select name="department_id" id="department_id" class="form-select">
            <option value=""><?php echo e(__('Select Department')); ?></option>
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->id); ?>" <?php echo e(old('department_id', $feedback->department_id ?? '') == $dept->id ? 'selected' : ''); ?>>
                    <?php echo e($dept->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="col-md-12 mb-3">
        <label for="attachment" class="form-label"><?php echo e(__('Attachment (Optional)')); ?></label>
        <input type="file" name="attachment" id="attachment" class="form-control">
        <?php if(!empty($feedback->attachment)): ?>
            <small class="text-muted"><?php echo e(__('Current File:')); ?>

                <a href="<?php echo e(asset('storage/' . $feedback->attachment)); ?>" target="_blank"><?php echo e(__('View')); ?></a>
            </small>
        <?php endif; ?>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\_form.blade.php ENDPATH**/ ?>