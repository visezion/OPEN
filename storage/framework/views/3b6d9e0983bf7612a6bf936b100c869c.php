<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Openzion')); ?> - <?php echo e(__('Public Portal')); ?></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700;800&display=swap" rel="stylesheet" />

    <?php
        $viteManifestPath = public_path('build/manifest.json');
        $viteHotPath = public_path('hot');
        $legacyCssPath = public_path('css/app.css');
        $legacyJsPath = public_path('js/app.js');
    ?>
    <?php if(file_exists($viteManifestPath) || file_exists($viteHotPath)): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <?php if(file_exists($legacyCssPath)): ?>
            <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <?php endif; ?>
        <?php if(file_exists($legacyJsPath)): ?>
            <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
        <?php endif; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">

    <?php
        $workspaceModel = $workspace instanceof \App\Models\WorkSpace
            ? $workspace
            : (\is_numeric($workspace) ? \App\Models\WorkSpace::find((int) $workspace) : null);

        if (! $workspaceModel && !empty($workspace) && \is_string($workspace)) {
            $workspaceModel = \App\Models\WorkSpace::where('slug', $workspace)
                ->orWhere('domain', $workspace)
                ->orWhere('subdomain', $workspace)
                ->first();
        }

        $workspaceModel = $workspaceModel ?? \App\Models\WorkSpace::find(getActiveWorkSpace());

        $workspaceProfile = $workspaceModel
            ? \Workdo\Churchly\Entities\ChurchAppProfile::where('workspace_id', $workspaceModel->id)->first()
            : null;

        $normalizeHex = static function ($value, $fallback) {
            $value = trim((string) $value);
            if ($value === '') {
                return $fallback;
            }
            if (!preg_match('/^#?[0-9a-fA-F]{6}([0-9a-fA-F]{2})?$/', $value)) {
                return $fallback;
            }
            $value = ltrim($value, '#');
            if (strlen($value) === 8) {
                $value = substr($value, 0, 6);
            }
            return '#'.strtolower($value);
        };

        $primaryColor = $normalizeHex($workspaceProfile->primary_color ?? null, '#2f5bea');
        $accentColor = $normalizeHex($workspaceProfile->accent_color ?? null, '#1a2c57');
        $backgroundColor = $normalizeHex($workspaceProfile->background_color ?? null, '#f6f8fc');
        $textColor = $normalizeHex($workspaceProfile->text_color ?? null, '#1f2b46');

        $primaryRgb = [
            hexdec(substr($primaryColor, 1, 2)),
            hexdec(substr($primaryColor, 3, 2)),
            hexdec(substr($primaryColor, 5, 2)),
        ];
        $primaryRgbString = implode(', ', $primaryRgb);

        $companyLogo = null;
        if ($workspaceModel?->created_by && $workspaceModel?->id) {
            $companySettings = getCompanyAllSetting($workspaceModel->created_by, $workspaceModel->id);
            if (!empty($companySettings['logo_light']) && check_file($companySettings['logo_light'])) {
                $companyLogo = get_file($companySettings['logo_light']);
            } elseif (!empty($companySettings['logo_dark']) && check_file($companySettings['logo_dark'])) {
                $companyLogo = get_file($companySettings['logo_dark']);
            }
        }

        $logoUrl = !empty($workspaceProfile?->logo_path)
            ? asset(\Illuminate\Support\Facades\Storage::url($workspaceProfile->logo_path))
            : ($companyLogo ?? asset('uploads/logo/logo_dark.png'));

        $workspaceName = $workspaceModel?->name ?? config('app.name', 'Openzion');
        $workspaceDescription = trim((string) ($workspaceProfile->short_description ?? ''));
        if ($workspaceDescription === '') {
            $workspaceDescription = __('Secure church operations and member engagement from one workspace.');
        }

        $workspaceLink = url('/');
        if (!empty($workspaceModel?->slug)) {
            $workspaceLink = url($workspaceModel->slug);
        }
    ?>

    <style>
        :root {
            --portal-primary: <?php echo e($primaryColor); ?>;
            --portal-accent: <?php echo e($accentColor); ?>;
            --portal-bg: <?php echo e($backgroundColor); ?>;
            --portal-text: <?php echo e($textColor); ?>;
            --portal-primary-rgb: <?php echo e($primaryRgbString); ?>;
            --portal-border: rgba(24, 40, 72, 0.14);
        }

        body.workspace-portal-body {
            margin: 0;
            background: linear-gradient(170deg, rgba(var(--portal-primary-rgb), 0.08), transparent 38%), var(--portal-bg);
            color: var(--portal-text);
            font-family: "Figtree", "Segoe UI", Roboto, Arial, sans-serif;
        }

        .workspace-portal-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .workspace-portal-shell {
            width: min(1160px, 100%);
            min-height: 680px;
            border: 1px solid var(--portal-border);
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            display: grid;
            grid-template-columns: 38% 62%;
        }

        .workspace-portal-aside {
            padding: 34px 30px;
            border-right: 1px solid var(--portal-border);
            background:
                radial-gradient(circle at 22% 12%, rgba(var(--portal-primary-rgb), 0.20), transparent 38%),
                linear-gradient(165deg, #ffffff 0%, rgba(var(--portal-primary-rgb), 0.07) 100%);
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .workspace-logo-wrap {
            display: inline-flex;
            align-items: center;
            max-width: 240px;
        }

        .workspace-logo-wrap img {
            max-height: 56px;
            width: auto;
            object-fit: contain;
        }

        .workspace-badge {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(var(--portal-primary-rgb), 0.35);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--portal-primary);
            width: fit-content;
        }

        .workspace-title {
            margin: 0;
            font-size: 2rem;
            line-height: 1.18;
            font-weight: 800;
            color: var(--portal-accent);
        }

        .workspace-subtitle {
            margin: 0;
            color: #4d5f80;
            line-height: 1.65;
        }

        .workspace-feature-list {
            margin: 10px 0 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 10px;
        }

        .workspace-feature-list li {
            border: 1px solid var(--portal-border);
            border-radius: 10px;
            padding: 10px 12px;
            background: #ffffff;
            color: #304869;
            font-weight: 600;
            font-size: 14px;
        }

        .workspace-portal-main {
            padding: 34px 30px;
            overflow: auto;
        }

        .portal-page-head {
            margin-bottom: 18px;
        }

        .portal-page-title {
            margin: 0;
            font-size: 1.75rem;
            line-height: 1.2;
            font-weight: 800;
            color: var(--portal-accent);
        }

        .portal-page-subtitle {
            margin: 8px 0 0;
            color: #5b6d8d;
            line-height: 1.65;
        }

        .portal-alert {
            border: 1px solid var(--portal-border);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .portal-alert.success {
            border-color: rgba(26, 142, 84, 0.25);
            background: #ecfdf3;
            color: #166a46;
        }

        .portal-alert.error {
            border-color: rgba(218, 74, 74, 0.25);
            background: #fff1f1;
            color: #8f2a2a;
        }

        .portal-form {
            display: grid;
            gap: 14px;
        }

        .portal-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .portal-field {
            display: grid;
            gap: 6px;
        }

        .portal-label {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #5f7291;
        }

        .portal-input,
        .portal-select,
        .portal-textarea {
            width: 100%;
            border: 1px solid var(--portal-border);
            border-radius: 10px;
            padding: 11px 12px;
            background: #ffffff;
            color: #152846;
            font-size: 14px;
            outline: none;
        }

        .portal-input:focus,
        .portal-select:focus,
        .portal-textarea:focus {
            border-color: rgba(var(--portal-primary-rgb), 0.7);
            box-shadow: 0 0 0 3px rgba(var(--portal-primary-rgb), 0.13);
        }

        .portal-file-input {
            width: 100%;
            border: 1px dashed rgba(var(--portal-primary-rgb), 0.48);
            border-radius: 10px;
            padding: 9px 10px;
            background: rgba(var(--portal-primary-rgb), 0.04);
            color: #2b3f61;
            font-size: 13px;
        }

        .portal-submit {
            border: 1px solid var(--portal-primary);
            border-radius: 10px;
            background: var(--portal-primary);
            color: #ffffff;
            padding: 12px 16px;
            font-weight: 700;
            font-size: 14px;
            width: 100%;
            cursor: pointer;
        }

        .portal-submit:hover {
            filter: brightness(0.96);
        }

        @media (max-width: 1023px) {
            .workspace-portal-shell {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .workspace-portal-aside {
                border-right: 0;
                border-bottom: 1px solid var(--portal-border);
            }
        }

        @media (max-width: 640px) {
            .workspace-portal-wrap {
                padding: 16px 12px;
            }

            .workspace-portal-aside,
            .workspace-portal-main {
                padding: 22px 16px;
            }

            .portal-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .workspace-title {
                font-size: 1.5rem;
            }

            .portal-page-title {
                font-size: 1.35rem;
            }
        }
    </style>
</head>
<body class="workspace-portal-body ui-border-clean">
    <div class="workspace-portal-wrap">
        <div class="workspace-portal-shell">
            <aside class="workspace-portal-aside">
                <a href="<?php echo e($workspaceLink); ?>" class="workspace-logo-wrap" title="<?php echo e($workspaceName); ?>">
                    <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($workspaceName); ?>">
                </a>
                <span class="workspace-badge"><?php echo e(__('Workspace Portal')); ?></span>
                <h1 class="workspace-title"><?php echo e($workspaceName); ?></h1>
                <p class="workspace-subtitle"><?php echo e($workspaceDescription); ?></p>
                <ul class="workspace-feature-list">
                    <li><?php echo e(__('Secure public forms')); ?></li>
                    <li><?php echo e(__('Workspace-branded experience')); ?></li>
                    <li><?php echo e(__('Clear communication with your team')); ?></li>
                </ul>
            </aside>
            <main class="workspace-portal-main">
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/layouts/guest.blade.php ENDPATH**/ ?>