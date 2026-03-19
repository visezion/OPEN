<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve(['workspace' => $workspace] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="portal-page-head">
        <h2 class="portal-page-title"><?php echo e(__('Share Feedback with the Leadership Team')); ?></h2>
        <p class="portal-page-subtitle">
            <?php echo e(__('Submit suggestions, concerns, and testimonies so your church team can respond with care and accountability.')); ?>

        </p>
    </div>

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

    <?php if(session('success')): ?>
        <div class="portal-alert success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('churchly.feedback.submit', ['workspace' => $workspace->slug ?? request()->route('workspace')])); ?>" enctype="multipart/form-data" class="portal-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="type" value="public">

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Title (optional)')); ?></label>
                <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="portal-input" placeholder="<?php echo e(__('Short summary title')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Category')); ?></label>
                <select name="category" class="portal-select" required>
                    <option value=""><?php echo e(__('Select category')); ?></option>
                    <option value="suggestion" <?php if(old('category') === 'suggestion'): echo 'selected'; endif; ?>><?php echo e(__('Suggestion')); ?></option>
                    <option value="complaint" <?php if(old('category') === 'complaint'): echo 'selected'; endif; ?>><?php echo e(__('Complaint')); ?></option>
                    <option value="praise" <?php if(old('category') === 'praise'): echo 'selected'; endif; ?>><?php echo e(__('Praise')); ?></option>
                    <option value="other" <?php if(old('category') === 'other'): echo 'selected'; endif; ?>><?php echo e(__('Other')); ?></option>
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Name (optional)')); ?></label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="portal-input" placeholder="<?php echo e(__('Your name')); ?>">
            </div>
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Email (optional)')); ?></label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="portal-input" placeholder="<?php echo e(__('Your email')); ?>">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label"><?php echo e(__('Message')); ?></label>
            <textarea name="message" rows="6" required class="portal-textarea" placeholder="<?php echo e(__('Type your feedback in detail')); ?>"><?php echo e(old('message')); ?></textarea>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label"><?php echo e(__('Attachment (optional)')); ?></label>
                <input type="file" name="attachment" class="portal-file-input">
            </div>
            <div class="portal-field" style="align-content: end;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #425779;">
                    <input type="checkbox" name="is_anonymous" value="1" <?php if(old('is_anonymous')): echo 'checked'; endif; ?>>
                    <span><?php echo e(__('Submit anonymously')); ?></span>
                </label>
            </div>
        </div>

        <button type="submit" class="portal-submit"><?php echo e(__('Send Feedback')); ?></button>
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
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/feedback/public_form.blade.php ENDPATH**/ ?>