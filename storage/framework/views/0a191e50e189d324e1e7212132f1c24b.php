<?php
    $adminSettings = getAdminAllSetting();
    $workspaceId = $workspaceId ?? ($attendanceEvent->workspace_id ?? getActiveWorkSpace());
    $workspaceOwnerId = null;

    if (!empty($workspaceId) && class_exists(\App\Models\WorkSpace::class)) {
        $workspaceOwnerId = \App\Models\WorkSpace::query()
            ->where('id', $workspaceId)
            ->value('created_by');
    }

    $companySettings = $workspaceOwnerId ? getCompanyAllSetting($workspaceOwnerId, $workspaceId) : [];
    $themePalette = [
        'theme-1' => '#0CAF60',
        'theme-2' => '#75C251',
        'theme-3' => '#584ED2',
        'theme-4' => '#145388',
        'theme-5' => '#B9406B',
        'theme-6' => '#008ECC',
        'theme-7' => '#922C88',
        'theme-8' => '#C0A145',
        'theme-9' => '#48494B',
        'theme-10' => '#0C7785',
    ];

    $rawBrandColor = trim((string) ($companySettings['color'] ?? $adminSettings['color'] ?? 'theme-4'));
    $normalizedBrandColor = strtolower($rawBrandColor);
    $brandPrimary = $themePalette[$normalizedBrandColor] ?? '#145388';

    if (!isset($themePalette[$normalizedBrandColor]) && $rawBrandColor !== '') {
        $candidateBrandColor = str_starts_with($rawBrandColor, '#') ? $rawBrandColor : '#' . $rawBrandColor;
        if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $candidateBrandColor)) {
            $brandPrimary = $candidateBrandColor;
        }
    }

    $brandHex = ltrim($brandPrimary, '#');
    if (strlen($brandHex) === 3) {
        $brandHex = preg_replace('/(.)/', '$1$1', $brandHex);
    }
    $brandRgb = sscanf(substr($brandHex, 0, 6), '%02x%02x%02x') ?: [20, 83, 136];
    $brandRgbString = implode(', ', $brandRgb);

    $favicon = $companySettings['favicon'] ?? ($adminSettings['favicon'] ?? 'uploads/logo/favicon.png');
    $logoPath = sidebar_logo();
    if (!empty($companySettings['logo_light']) && check_file($companySettings['logo_light'])) {
        $logoPath = $companySettings['logo_light'];
    } elseif (!empty($companySettings['logo_dark']) && check_file($companySettings['logo_dark'])) {
        $logoPath = $companySettings['logo_dark'];
    }

    $logoUrl = check_file($logoPath) ? get_file($logoPath) : get_file('uploads/logo/logo_dark.png');
    $appTitle = $companySettings['title_text'] ?? ($adminSettings['title_text'] ?? config('app.name', 'WorkDo'));
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('page-title'); ?> | <?php echo e($appTitle); ?></title>
    <link rel="icon" href="<?php echo e(check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png')); ?><?php echo e('?'.time()); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">

    <style>
        :root {
            --churchmeet-public-primary: <?php echo e($brandPrimary); ?>;
            --churchmeet-public-primary-rgb: <?php echo e($brandRgbString); ?>;
            --churchmeet-public-ink: #102840;
            --churchmeet-public-muted: #61748d;
            --churchmeet-public-border: rgba(16, 40, 64, 0.12);
            --churchmeet-public-soft: rgba(<?php echo e($brandRgbString); ?>, 0.08);
        }

        body.churchmeet-public-layout {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(<?php echo e($brandRgbString); ?>, 0.16), transparent 30%),
                radial-gradient(circle at right 12%, rgba(<?php echo e($brandRgbString); ?>, 0.10), transparent 26%),
                linear-gradient(180deg, #f4f8fc 0%, #f8fbff 100%);
            color: var(--churchmeet-public-ink);
            font-family: "DM Sans", "Segoe UI", sans-serif;
        }

        .churchmeet-public-frame {
            min-height: 100vh;
            padding: 24px;
        }

        .churchmeet-public-shell {
            width: min(1460px, 100%);
            margin: 0 auto;
            border: 1px solid var(--churchmeet-public-border);
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 28px 70px rgba(20, 83, 136, 0.10);
            backdrop-filter: blur(16px);
        }

        .churchmeet-public-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 18px 24px;
            border-bottom: 1px solid var(--churchmeet-public-border);
            background: linear-gradient(180deg, rgba(<?php echo e($brandRgbString); ?>, 0.07), rgba(255, 255, 255, 0.86));
        }

        .churchmeet-public-brand {
            display: flex;
            align-items: center;
            gap: 0.95rem;
            min-width: 0;
        }

        .churchmeet-public-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            min-height: 48px;
            padding: 0.45rem 0.7rem;
            border-radius: 14px;
            background: #fff;
            border: 1px solid var(--churchmeet-public-border);
        }

        .churchmeet-public-logo img {
            max-height: 34px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .churchmeet-public-kicker {
            margin: 0 0 0.2rem;
            color: var(--churchmeet-public-muted);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .churchmeet-public-title {
            margin: 0;
            color: var(--churchmeet-public-ink);
            font-size: clamp(1.1rem, 1.8vw, 1.45rem);
            font-weight: 800;
            line-height: 1.15;
        }

        .churchmeet-public-subtitle {
            margin: 0.3rem 0 0;
            color: var(--churchmeet-public-muted);
            font-size: 0.92rem;
        }

        .churchmeet-public-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 0.55rem;
        }

        .churchmeet-public-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            min-height: 40px;
            padding: 0 0.85rem;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--churchmeet-public-border);
            color: var(--churchmeet-public-muted);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .churchmeet-public-pill.is-primary {
            color: var(--churchmeet-public-primary);
            background: rgba(<?php echo e($brandRgbString); ?>, 0.10);
            border-color: rgba(<?php echo e($brandRgbString); ?>, 0.18);
        }

        .churchmeet-public-main {
            padding: 24px;
        }

        @media (max-width: 991.98px) {
            .churchmeet-public-frame {
                padding: 14px;
            }

            .churchmeet-public-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .churchmeet-public-badges {
                justify-content: flex-start;
            }

            .churchmeet-public-main {
                padding: 16px;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body class="churchmeet-public-layout ui-border-clean">
    <div class="churchmeet-public-frame">
        <div class="churchmeet-public-shell">
            <header class="churchmeet-public-header">
                <div class="churchmeet-public-brand">
                    <span class="churchmeet-public-logo">
                        <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($appTitle); ?>">
                    </span>
                    <div>
                        <p class="churchmeet-public-kicker"><?php echo e(__('ChurchMeet Public Access')); ?></p>
                        <h1 class="churchmeet-public-title"><?php echo $__env->yieldContent('page-title'); ?></h1>
                        <p class="churchmeet-public-subtitle"><?php echo e(__('Join the meeting securely from any device without signing in.')); ?></p>
                    </div>
                </div>
                <div class="churchmeet-public-badges">
                    <span class="churchmeet-public-pill is-primary"><i class="ti ti-shield-check"></i> <?php echo e(__('Secure Join')); ?></span>
                    <span class="churchmeet-public-pill"><i class="ti ti-device-laptop"></i> <?php echo e(__('Works in Browser')); ?></span>
                </div>
            </header>

            <main class="churchmeet-public-main">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Providers/../Resources/views/layouts/public_join.blade.php ENDPATH**/ ?>