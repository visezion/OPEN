<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Session Timeout')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('body-class'); ?>
    <?php echo e(' faith-login-page dms-faith-login session-expired-page'); ?>

<?php $__env->stopSection(); ?>

<?php
    $admin_settings = getAdminAllSetting();
    $brandName = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : config('app.name', 'Openzion');
    $dashboardUrl = auth()->check() ? route('dashboard') : route('login');
?>

<?php $__env->startSection('content'); ?>
    <div class="dms-content-logo">
        <img src="<?php echo e(get_file(sidebar_logo())); ?><?php echo e('?' . time()); ?>" alt="<?php echo e($brandName); ?>">
    </div>

    <style>
        body.session-expired-page .dms-faith-layout {
            gap: 0;
            border: 1px solid #d8e2ef;
            border-radius: 18px;
            overflow: hidden;
            min-height: 700px;
            background: #ffffff;
            grid-template-columns: minmax(0, 1.05fr) minmax(420px, 0.95fr);
        }

        body.session-expired-page .dms-faith-hero {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 24px;
            min-height: 700px;
            padding: 28px 28px 32px;
            border-right: 1px solid #d8e2ef;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.16), transparent 28%),
                radial-gradient(circle at bottom right, rgba(15, 118, 110, 0.12), transparent 24%),
                linear-gradient(160deg, #132238 0%, #1d2d4b 56%, #264a76 100%);
            color: #f8fbff;
        }

        body.session-expired-page .dms-expired-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: fit-content;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #dbeafe;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        body.session-expired-page .dms-expired-code {
            font-size: clamp(4.5rem, 10vw, 7rem);
            line-height: 0.9;
            letter-spacing: -0.05em;
            font-weight: 700;
            margin: 0 0 12px;
        }

        body.session-expired-page .dms-expired-title {
            margin: 0 0 16px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.04;
            color: #ffffff;
        }

        body.session-expired-page .dms-expired-copy {
            margin: 0;
            max-width: 560px;
            color: rgba(226, 232, 240, 0.86);
            font-size: 1rem;
            line-height: 1.8;
        }

        body.session-expired-page .dms-expired-points {
            display: grid;
            gap: 14px;
        }

        body.session-expired-page .dms-expired-point {
            padding: 16px 18px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        body.session-expired-page .dms-expired-point strong {
            display: block;
            margin-bottom: 6px;
            color: #ffffff;
        }

        body.session-expired-page .dms-expired-point span {
            color: rgba(226, 232, 240, 0.82);
            line-height: 1.7;
        }

        body.session-expired-page .dms-faith-form-zone {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 26px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        body.session-expired-page .dms-faith-card {
            width: min(100%, 520px);
        }

        body.session-expired-page .dms-expired-actions {
            display: grid;
            gap: 12px;
            margin-top: 22px;
        }

        body.session-expired-page .dms-expired-actions .btn {
            min-height: 50px;
            border-radius: 12px;
            font-weight: 600;
        }

        body.session-expired-page .dms-expired-actions .btn-light {
            background: #f4f7fb;
            border-color: #d8e2ef;
        }

        body.session-expired-page .dms-expired-checks {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        body.session-expired-page .dms-expired-check {
            display: grid;
            grid-template-columns: 28px 1fr;
            gap: 12px;
            align-items: start;
            color: #5f7088;
            line-height: 1.7;
        }

        body.session-expired-page .dms-expired-check span {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #eef4fb;
            color: #1d4ed8;
            font-size: 0.85rem;
            font-weight: 700;
        }

        body.session-expired-page .dms-expired-status {
            margin-top: 18px;
            color: #7b8ba3;
            font-size: 0.9rem;
        }

        @media (max-width: 991px) {
            body.session-expired-page .dms-faith-layout {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            body.session-expired-page .dms-faith-hero {
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid #d8e2ef;
            }
        }
    </style>

    <div class="dms-faith-layout">
        <section class="dms-faith-hero">
            <div>
                <div class="dms-expired-badge"><?php echo e(__('Session Timeout')); ?></div>

                <div class="mt-4">
                    <p class="dms-expired-code">419</p>
                    <h1 class="dms-expired-title"><?php echo e(__('This page lost its secure session.')); ?></h1>
                    <p class="dms-expired-copy">
                        <?php echo e(__('The form or action you opened no longer holds a valid security token. This usually happens after a long idle period, when the same form stays open in multiple tabs, or when the browser sends back an older saved page state.')); ?>

                    </p>
                </div>
            </div>

            <div class="dms-expired-points">
                <div class="dms-expired-point">
                    <strong><?php echo e(__('What happened')); ?></strong>
                    <span><?php echo e(__('OPEN blocked the request because the page token expired before submission. That is safer than accepting an outdated request.')); ?></span>
                </div>

                <div class="dms-expired-point">
                    <strong><?php echo e(__('Best next step')); ?></strong>
                    <span><?php echo e(__('Refresh this page first, then repeat the action from a fresh screen so the newest session token is used.')); ?></span>
                </div>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label"><?php echo e(__('Recover Quickly')); ?></p>
                        <h2><?php echo e(__('Get back into the flow')); ?></h2>
                        <p class="dms-card-copy"><?php echo e(__('Use the actions below to reopen the request safely.')); ?></p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">
                        <i class="ti ti-refresh"></i>
                    </div>
                </div>

                <div class="dms-expired-actions">
                    <a href="<?php echo e(url()->current()); ?>" class="btn btn-primary dms-submit-btn">
                        <i class="ti ti-rotate-clockwise-2 me-1"></i><?php echo e(__('Refresh This Page')); ?>

                    </a>
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-primary">
                        <i class="ti ti-arrow-left me-1"></i><?php echo e(__('Go Back Safely')); ?>

                    </a>
                    <a href="<?php echo e($dashboardUrl); ?>" class="btn btn-light">
                        <i class="ti ti-layout-dashboard me-1"></i>
                        <?php echo e(auth()->check() ? __('Open Dashboard') : __('Open Sign In')); ?>

                    </a>
                </div>

                <div class="dms-faith-card mt-4" style="padding: 22px 20px; border: 1px solid #d8e2ef; box-shadow: none; background: #fff;">
                    <h5 class="mb-3"><?php echo e(__('Helpful Checks')); ?></h5>
                    <div class="dms-expired-checks">
                        <div class="dms-expired-check">
                            <span>1</span>
                            <div><?php echo e(__('If you had multiple copies of the same form open, close the older tabs and keep only one active version.')); ?></div>
                        </div>
                        <div class="dms-expired-check">
                            <span>2</span>
                            <div><?php echo e(__('If you signed out in another window, sign in again before retrying the action.')); ?></div>
                        </div>
                        <div class="dms-expired-check">
                            <span>3</span>
                            <div><?php echo e(__('If this repeats often on one screen, refresh before long idle review or edit sessions.')); ?></div>
                        </div>
                    </div>
                </div>

                <div class="dms-expired-status">
                    <?php echo e(__('Status')); ?>: 419 - <?php echo e(__('Page Expired')); ?> - <?php echo e($brandName); ?>

                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/errors/419.blade.php ENDPATH**/ ?>