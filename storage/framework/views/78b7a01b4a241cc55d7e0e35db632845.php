<?php $__env->startSection('page-title', __('Integrations')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('ChurchMeet')); ?>,<?php echo e(__('Integrations')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .churchmeet-integrations .card { border: 1px solid #d8e2ef !important; box-shadow: none !important; }
    .churchmeet-integrations .hero-card { border-top: 3px solid #245f86 !important; background: linear-gradient(180deg, rgba(36,95,134,.06), rgba(36,95,134,0)), #fff; }
    .churchmeet-integrations .platform-card { border: 1px solid #d8e2ef; border-radius: 12px; padding: 1rem; background: #f7fafc; }
    .churchmeet-integrations .platform-card.is-active { border-color: #245f86; background: #eef4fa; }
    .churchmeet-integrations .section-copy { color: #6b7d90; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row churchmeet-integrations">
    <div class="col-12 mb-4">
        <div class="card hero-card">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start">
                    <div>
                        <h4 class="mb-2"><?php echo e(__('ChurchMeet Integrations')); ?></h4>
                        <p class="section-copy mb-0"><?php echo e(__('Configure Zoom and Jitsi from one place, then choose which platform ChurchMeet should prefer when admins create online events.')); ?></p>
                    </div>
                    <span class="badge bg-light text-primary border"><?php echo e(__('Workspace Settings')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white p-4">
                <h5 class="mb-1"><?php echo e(__('Meeting Platform Settings')); ?></h5>
                <p class="section-copy mb-0"><?php echo e(__('Jitsi can work immediately with a public or self-hosted server. Zoom requires API credentials for meeting creation and in-app join.')); ?></p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('churchmeet.integrations.save')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block"><?php echo e(__('Preferred Platform')); ?></label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="platform-card d-block <?php echo e(old('preferred_platform', $setting->preferred_platform ?: 'jitsi') === 'jitsi' ? 'is-active' : ''); ?>">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_platform" value="jitsi" <?php echo e(old('preferred_platform', $setting->preferred_platform ?: 'jitsi') === 'jitsi' ? 'checked' : ''); ?>>
                                        <span class="fw-semibold ms-1"><?php echo e(__('Jitsi Meet')); ?></span>
                                    </div>
                                    <div class="text-muted mt-2"><?php echo e(__('Best when you want a simple built-in meeting option without Zoom credentials.')); ?></div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="platform-card d-block <?php echo e(old('preferred_platform', $setting->preferred_platform ?: 'jitsi') === 'zoom' ? 'is-active' : ''); ?>">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_platform" value="zoom" <?php echo e(old('preferred_platform', $setting->preferred_platform ?: 'jitsi') === 'zoom' ? 'checked' : ''); ?>>
                                        <span class="fw-semibold ms-1"><?php echo e(__('Zoom')); ?></span>
                                    </div>
                                    <div class="text-muted mt-2"><?php echo e(__('Best when you need Zoom scheduling, participant sync, and Meeting SDK support.')); ?></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><?php echo e(__('Jitsi Configuration')); ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="jitsi_enabled" value="1" <?php echo e(old('jitsi_enabled', $setting->jitsi_enabled ?? true) ? 'checked' : ''); ?>>
                                <label class="form-check-label"><?php echo e(__('Enable Jitsi in ChurchMeet')); ?></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('Jitsi Server Domain')); ?></label>
                                <input type="text" name="jitsi_server_domain" value="<?php echo e(old('jitsi_server_domain', $setting->jitsi_server_domain ?: 'meet.jit.si')); ?>" class="form-control" placeholder="meet.jit.si">
                                <small class="text-muted d-block mt-1"><?php echo e(__('Use only the host name. ChurchMeet will build the room URL automatically.')); ?></small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label"><?php echo e(__('Room Prefix')); ?></label>
                                <input type="text" name="jitsi_room_prefix" value="<?php echo e(old('jitsi_room_prefix', $setting->jitsi_room_prefix)); ?>" class="form-control" placeholder="churchmeet">
                                <small class="text-muted d-block mt-1"><?php echo e(__('Optional prefix added to generated Jitsi room names.')); ?></small>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><?php echo e(__('Zoom Configuration')); ?></h6>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('churchmeet.integrations.zoom.test')); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Test Connection')); ?></a>
                                <a href="<?php echo e(route('churchmeet.integrations.zoom.sync')); ?>" class="btn btn-sm btn-outline-primary"><?php echo e(__('Sync Now')); ?></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Account ID')); ?></label>
                                    <input type="text" name="account_id" value="<?php echo e(old('account_id', $setting->account_id)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Host User ID or Email')); ?></label>
                                    <input type="text" name="host_user_id" value="<?php echo e(old('host_user_id', $setting->host_user_id)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Client ID')); ?></label>
                                    <input type="text" name="client_id" value="<?php echo e(old('client_id', $setting->client_id)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Client Secret')); ?></label>
                                    <input type="text" name="client_secret" value="<?php echo e(old('client_secret', $setting->client_secret)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Meeting SDK Key')); ?></label>
                                    <input type="text" name="meeting_sdk_key" value="<?php echo e(old('meeting_sdk_key', $setting->meeting_sdk_key)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Meeting SDK Secret')); ?></label>
                                    <input type="text" name="meeting_sdk_secret" value="<?php echo e(old('meeting_sdk_secret', $setting->meeting_sdk_secret)); ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Sync Interval')); ?></label>
                                    <select name="interval_minutes" class="form-select">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [5,10,15,30,60,120,360,720,1440]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $minutes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($minutes); ?>" <?php echo e((int) old('interval_minutes', $setting->interval_minutes ?? 15) === $minutes ? 'selected' : ''); ?>>
                                                <?php echo e($minutes < 60 ? $minutes.' min' : ($minutes % 1440 === 0 ? 'Daily' : ($minutes / 60).' hr')); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" <?php echo e(old('active', $setting->active) ? 'checked' : ''); ?>>
                                        <label class="form-check-label"><?php echo e(__('Enable Zoom auto sync')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary"><?php echo e(__('Save Integration Settings')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header bg-white"><h6 class="mb-0"><?php echo e(__('Current Status')); ?></h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Preferred Platform')); ?></span><strong><?php echo e(strtoupper($setting->preferred_platform ?: 'JITSI')); ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Jitsi Domain')); ?></span><strong><?php echo e($setting->jitsi_server_domain ?: 'meet.jit.si'); ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Jitsi Enabled')); ?></span><strong><?php echo e(($setting->jitsi_enabled ?? true) ? __('Yes') : __('No')); ?></strong></div>
                <div class="d-flex justify-content-between"><span class="text-muted"><?php echo e(__('Zoom Credentials')); ?></span><strong><?php echo e($setting->account_id && $setting->client_id && $setting->client_secret ? __('Configured') : __('Incomplete')); ?></strong></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white"><h6 class="mb-0"><?php echo e(__('Recent Online Events')); ?></h6></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold"><?php echo e($event->event->title ?? __('Event')); ?></div>
                                <small class="text-muted"><?php echo e(strtoupper($event->online_platform ?: 'N/A')); ?> • <?php echo e($event->meeting_id ?: __('No room yet')); ?></small>
                            </div>
                            <a href="<?php echo e(route('churchmeet.attendance_events.edit', $event->id)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Open')); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="list-group-item px-0 text-muted"><?php echo e(__('No recent meeting-enabled events found.')); ?></li>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0"><?php echo e(__('Recent Zoom Participants')); ?></h6></div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="list-group-item px-0">
                            <div class="fw-semibold"><?php echo e($participant->user_name); ?></div>
                            <small class="text-muted"><?php echo e($participant->user_email); ?> • <?php echo e(__('Duration')); ?>: <?php echo e($participant->duration); ?>s</small>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-muted"><?php echo e(__('No Zoom participants have been synced yet.')); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Providers/../Resources/views/integrations/index.blade.php ENDPATH**/ ?>