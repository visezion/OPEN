<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5><?php echo e(__('Custom JS and CSS')); ?></h5>
            </div>
            <div id="p1" class="col-auto text-end text-primary h3">
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <?php echo e(Form::model(null, array('route' => array('landingpage.custom-js-css.setting.save'), 'method' => 'POST', 'class'=>'needs-validation', 'novalidate'))); ?>

            <div class="border">
                <div class="">
                    <div class="row align-items-center justify-content-between p-3">
                        <div class="mb-5 col-6">
                            <div class="form-group">
                                <?php echo e(Form::label('landingpage_custom_js', __('Custom JS'), ['class' => 'col-form-label text-dark'])); ?>

                                <?php echo e(Form::textarea('landingpage_custom_js', isset($settings['landingpage_custom_js']) ? $settings['landingpage_custom_js'] : '', [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'topbar_notification',
                                    'placeholder' => "$(document).ready(function() {\n    $('p').click(function(){\n        $(this).hide();\n    });\n});"  // Placeholder added
                                ])); ?>

                                <div class="text-xs text-danger mt-1">
                                    <?php echo e(__('Note : Please put your JS without <script></script> tag.')); ?>

                                </div>
                            </div>

                        </div>

                        <div class="mb-5 col-6">
                            <div class="form-group">
                                <?php echo e(Form::label('landingpage_custom_css', __('Custom CSS'), ['class' => 'col-form-label text-dark'])); ?>

                                <?php echo e(Form::textarea('landingpage_custom_css', isset($settings['landingpage_custom_css']) ? $settings['landingpage_custom_css'] : '', [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'topbar_notification',
                                    'placeholder' => "#para1 {\n    text-align: center;\n    color: red;\n}"  // Added CSS placeholder
                                ])); ?>

                                <div class="text-xs text-danger mt-1">
                                    <?php echo e(__('Note : Please put your CSS without <style></style> tag.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3 text-end">
                    <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                </div>
            </div>
        <?php echo e(Form::close()); ?>

        
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\landingpage\custom\custom_js_css\index.blade.php ENDPATH**/ ?>