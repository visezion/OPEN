

<?php $__env->startSection('page-title', __('SMS Gateway Settings')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-sm-3">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-settings text-primary"></i> <?php echo e(__('Zender Credential Settings')); ?></h5>
                <p class="text-muted small mb-4">
                    <?php echo e(__('Configure your Zender credentials here to enable WhatsApp and SMS messaging inside Churchly. Once saved, these settings will be used automatically whenever messages are sent.')); ?>

                </p>

                <form method="POST" action="<?php echo e(route('sms-gateway.update')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-3">
                        <label class="fw-bold">Zender Site URL</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('Enter the full Zender domain. Do not add a trailing slash.')); ?>

                        </small>
                        <input type="text" name="url" value="<?php echo e($config['url'] ?? 'https://zender.vicezion.com'); ?>" class="form-control" required>
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">Zender API Key</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('Paste your API key from Zender. Ensure it has permissions:')); ?> 
                            <code>sms_send</code>, <code>wa_send</code>.
                        </small>
                        <input type="text" name="token" value="<?php echo e($config['token'] ?? ''); ?>" class="form-control" required>
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">Service</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('Select the default channel to use for sending messages. You may still override per-message.')); ?>

                        </small>
                        <select name="service" class="form-control" required>
                            <option value="whatsapp" <?php echo e(($config['service'] ?? '') == 'whatsapp' ? 'selected' : ''); ?>>WhatsApp</option>
                            <option value="sms" <?php echo e(($config['service'] ?? '') == 'sms' ? 'selected' : ''); ?>>SMS</option>
                        </select>
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">WhatsApp Account ID</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('Required for WhatsApp service. Copy the account ID from your Zender dashboard.')); ?>

                        </small>
                        <input type="text" name="whatsapp" value="<?php echo e($config['whatsapp'] ?? ''); ?>" class="form-control">
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">Device Unique ID</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('Required for SMS service (linked Android device). Leave blank if using WhatsApp only.')); ?>

                        </small>
                        <input type="text" name="device" value="<?php echo e($config['device'] ?? ''); ?>" class="form-control">
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">Gateway Unique ID</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('For SMS service only. Use if sending through a partner device or gateway.')); ?>

                        </small>
                        <input type="text" name="gateway" value="<?php echo e($config['gateway'] ?? ''); ?>" class="form-control">
                    </div>

                    
                    <div class="mb-3">
                        <label class="fw-bold">SIM Slot</label>
                        <small class="form-text text-muted d-block">
                            <?php echo e(__('For SMS service only. Select which SIM slot to use on your Android device.')); ?>

                        </small>
                        <select name="sim" class="form-control">
                            <option value="">-- Select SIM --</option>
                            <option value="SIM 1" <?php echo e(($config['sim'] ?? '') == 'SIM 1' ? 'selected' : ''); ?>>SIM 1</option>
                            <option value="SIM 2" <?php echo e(($config['sim'] ?? '') == 'SIM 2' ? 'selected' : ''); ?>>SIM 2</option>
                        </select>
                    </div>

                    <button class="btn btn-primary mt-3">
                        <i class="ti ti-device-floppy"></i> <?php echo e(__('Save Settings')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-sm-3">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-send text-success"></i> <?php echo e(__('Test Message')); ?></h6>
                <form method="POST" action="<?php echo e(route('sms-gateway.test-send')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label>Test Number</label>
                        <input type="text" name="test_number" class="form-control" placeholder="e.g. 2348012345678" required>
                    </div>

                    <div class="mb-3">
                        <label>Channel</label>
                        <select name="channel" class="form-control" required>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100">
                        <i class="ti ti-send"></i> <?php echo e(__('Send Test Message')); ?>

                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('About Zender Integration')); ?></h6>
                <p class="small text-muted">
                    <?php echo e(__('Zender is the official messaging engine powering WhatsApp and SMS features in Churchly. It connects directly to your WhatsApp accounts or linked devices, ensuring reliable delivery.')); ?>

                </p>

                <ul class="small text-muted ps-3">
                    <li><?php echo e(__('WhatsApp: Use for direct member engagement, announcements, and group chats.')); ?></li>
                    <li><?php echo e(__('SMS: Use for urgent alerts and members without WhatsApp.')); ?></li>
                    <li><?php echo e(__('Both services can be configured and selected per message.')); ?></li>
                </ul>

                <hr>

                <p class="small text-muted mb-0">
                    <strong>💡 Free for Churchly users:</strong> <?php echo e(__('Zender API is provided at no extra cost because both Churchly and Zender are owned by Vicezion. You can enjoy unlimited API usage without subscription fees.')); ?>

                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\sms\edit.blade.php ENDPATH**/ ?>