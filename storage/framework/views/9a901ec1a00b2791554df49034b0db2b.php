<form method="POST" action="<?php echo e(route('app-builder.saveFeatures')); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <?php
            $featureList = [
                'attendance' => 'Attendance',
                'events' => 'Events',
                'giving' => 'Giving',
                'sermons' => 'Sermons',
                'groups' => 'Groups',
                'announcements' => 'Announcements',
                'bible_reading' => 'Bible Reading',
                'livestream' => 'Live Stream'
            ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $featureList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $enabled = $features->where('feature_key',$key)->first()?->enabled ?? false; ?>
            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="features[<?php echo e($loop->index); ?>][enabled]" value="1" <?php echo e($enabled ? 'checked' : ''); ?>>
                    <input type="hidden" name="features[<?php echo e($loop->index); ?>][feature_key]" value="<?php echo e($key); ?>">
                    <label class="form-check-label"><?php echo e(__($label)); ?></label>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="text-end mt-3">
        <button class="btn btn-primary" type="submit"><?php echo e(__('Save Features')); ?></button>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\_features.blade.php ENDPATH**/ ?>