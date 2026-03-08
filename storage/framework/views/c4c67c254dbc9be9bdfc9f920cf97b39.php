<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Notification Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Notification Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>

<?php
$activeModule = '';
foreach ($notifications as $key => $value) {
    $txt = module_is_active($key);
    if ($txt == true) {
        $activeModule = $key;
        break;
    }
}

?>

<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end mb-4">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(module_is_active($key) && $key == 'Slack'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Slack" data-bs-toggle="pill"  data-bs-target="#slack-tab"
                                    type="button"><?php echo e(__('Slack')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Telegram'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Telegram" data-bs-toggle="pill"
                                    data-bs-target="#telegram-tab" type="button"><?php echo e(__('Telegram')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Twilio'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Twilio" data-bs-toggle="pill"
                                    data-bs-target="#twilio-tab" type="button"><?php echo e(__('Twilio')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Whatsapp'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Whatsapp" data-bs-toggle="pill" data-bs-target="#whatsapp-tab"
                                    type="button"><?php echo e(__('Whatsapp')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'WhatsAppAPI'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="WhatsAppAPI" data-bs-toggle="pill" data-bs-target="#whatsappapi-tab"
                                    type="button"><?php echo e(__('Whatsapp Api')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'SMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="SMS" data-bs-toggle="pill" data-bs-target="#sms-tab"
                                    type="button"><?php echo e(__('SMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Discord'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Discord" data-bs-toggle="pill" data-bs-target="#discord-tab"
                                    type="button"><?php echo e(__('Discord')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'RocketChat'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="RocketChat" data-bs-toggle="pill" data-bs-target="#rocketchat-tab"
                                    type="button"><?php echo e(__('RocketChat')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Fast2SMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Fast2SMS" data-bs-toggle="pill" data-bs-target="#fast2sms-tab"
                                    type="button"><?php echo e(__('Fast2SMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'VonageSMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="VonageSMS" data-bs-toggle="pill" data-bs-target="#vonagesms-tab"
                                    type="button"><?php echo e(__('VonageSMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'SinchSMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="SinchSMS" data-bs-toggle="pill" data-bs-target="#sinchsms-tab"
                                    type="button"><?php echo e(__('SinchSMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'Whatsender'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="Whatsender" data-bs-toggle="pill" data-bs-target="#whatsender-tab"
                                    type="button"><?php echo e(__('Whatsender')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'TelesignSMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="TelesignSMS" data-bs-toggle="pill" data-bs-target="#telesignsms-tab"
                                    type="button"><?php echo e(__('Telesign SMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'ZitaSMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="ZitaSMS" data-bs-toggle="pill" data-bs-target="#zitasms-tab"
                                    type="button"><?php echo e(__('ZitaSMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'PlivoSMS'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="PlivoSMS" data-bs-toggle="pill" data-bs-target="#plivosms-tab"
                                    type="button"><?php echo e(__('Plivo SMS')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'MSG91'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="MSG91" data-bs-toggle="pill" data-bs-target="#msg91-tab"
                                    type="button"><?php echo e(__('MSG91')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'AfricaTalking'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="AfricaTalking" data-bs-toggle="pill" data-bs-target="#africatalking-tab"
                                    type="button"><?php echo e(__('AfricaTalking')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(module_is_active($key) && $key == 'ClickSend'): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-id="ClickSend" data-bs-toggle="pill" data-bs-target="#clickSend-tab"
                                    type="button"><?php echo e(__('ClickSend')); ?></button>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body table-border-style">
                <?php if($activeModule == ''): ?>
                    <div class="text-center">
                        <h5 class="text-danger"><?php echo e(__('Make sure to activate at least one notification add-on. A notification template will be visible after that.')); ?></h5>
                    </div>
                <?php else: ?>
                    <div  class="table-responsive">
                        <?php echo e($dataTable->table(['width' => '100%'])); ?>

                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.information-tab .nav-link').first().addClass('active');
    });
</script>
<?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\notification_templates\index.blade.php ENDPATH**/ ?>