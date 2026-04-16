<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('Google Fonts')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="border">
            <?php echo e(Form::open(array('route' => 'landingpage.google.fonts', 'method'=>'post' ,'class'=>'needs-validation', 'novalidate'))); ?>

                <div class="card-body">
                    <!-- Body Settings -->
                    <div class="row mt-3 mb-3">
                        <div class="col-xl-6 col-sm-6 col-12">
                            <?php echo e(Form::label('body_fontfamily', __('Font Families'), ['class' => 'form-label'])); ?>

                            <select name="body_fontfamily"
                                class="form-control form-control-solid form-select mb-7">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $font_familys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>"
                                        <?php if(isset($settings['body_fontfamily']) && $settings['body_fontfamily']  == $value): ?> selected <?php endif; ?>>
                                        <?php echo e($value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>


<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\custom\google_fonts\index.blade.php ENDPATH**/ ?>