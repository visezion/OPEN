<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Print Setting')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Print-Settings')); ?>

<?php $__env->stopSection(); ?>

<?php
    $company_settings = getCompanyAllSetting();
?>

<?php $__env->startPush('scripts'); ?>
    <script>

        $(document).on("change", "select[name='purchase_template'], input[name='purchase_color']", function () {
            var template = $("select[name='purchase_template']").val();
            var color = $("input[name='purchase_color']:checked").val();
            $('#purchase_frame').attr('src', '<?php echo e(url('/purchase/preview')); ?>/' + template + '/' + color);
        });
        document.getElementById('purchase_logo').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('purchase_image').src = src
        }

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <!--Purchase Setting-->
                    <div class="tab-pane fade  show active" id="pills-purchase" role="tabpanel" aria-labelledby="pills-purchase-tab">
                        <div class="bg-none">
                            <div class="row company-setting">
                                <div class="col-md-3">
                                    <div class="card-header card-body">
                                        <h5></h5>
                                        <form id="setting-form" method="post" action="<?php echo e(route('purchase.template.setting')); ?>" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-group">
                                                <?php echo e(Form::label('purchase_template',__('Purchase Template'),array('class'=>'form-label'))); ?>

                                                <?php echo e(Form::select('purchase_template',Workdo\Account\Entities\AccountUtility::templateData()['templates'],isset($company_settings['purchase_template']) && !empty($company_settings['purchase_template']) ? $company_settings['purchase_template'] : null, array('class' => 'form-control choices','required'=>'required'))); ?>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"><?php echo e(__('Color Input')); ?></label>
                                                <div class="row gutters-xs">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = Workdo\Account\Entities\AccountUtility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-auto">
                                                            <label class="colorinput">
                                                                <input name="purchase_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($company_settings['purchase_color']) && !empty($company_settings['purchase_color']) && $company_settings['purchase_color'] == $color) ? 'checked' : ''); ?>>
                                                                <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"><?php echo e(__('Purchase Logo')); ?></label>
                                                    <label for="purchase_logo">
                                                        <input type="file" class="form-control file" name="purchase_logo" id="purchase_logo" data-filename="purchase_logo_update">
                                                        <img id="purchase_image" class="mt-2" style="width:50%;"/>
                                                </label>
                                            </div>
                                            <div class="form-group mt-2 text-end">
                                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-print-invoice  btn-primary m-r-10">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($company_settings['purchase_template']) && isset($company_settings['purchase_color']) && !empty( $company_settings['purchase_template']) && !empty($company_settings['purchase_color'])): ?>
                                        <iframe id="purchase_frame" class="w-100 h-100" frameborder="0" src="<?php echo e(route('purchase.preview',[$company_settings['purchase_template'], $company_settings['purchase_color']])); ?>"></iframe>
                                    <?php else: ?>
                                        <iframe id="purchase_frame" class="w-100 h-100" frameborder="0" src="<?php echo e(route('purchase.preview',['template1','fffff'])); ?>"></iframe>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<script>

    $(document).on("change", "select[name='purchase_template'], input[name='purchase_color']", function () {
        var template = $("select[name='purchase_template']").val();
        var color = $("input[name='purchase_color']:checked").val();
        $('#purchase_frame').attr('src', '<?php echo e(url('/purchase/preview')); ?>/' + template + '/' + color);
    });
    document.getElementById('purchase_logo').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('purchase_image').src = src
    }

</script>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\pos.blade.php ENDPATH**/ ?>