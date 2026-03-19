<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['workspace' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['workspace' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
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
        <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">
    </head>
    <body class="font-sans text-gray-900 antialiased ui-border-clean">
        <?php
            $workspaceParam = $workspace ?? null;
            $workspaceForLayout = $workspaceParam ?? \App\Models\WorkSpace::find(getActiveWorkSpace());
            $workspaceProfile = $workspaceForLayout
                ? \Workdo\Churchly\Entities\ChurchAppProfile::where('workspace_id', $workspaceForLayout->id)->first()
                : null;
            $primaryColor = $workspaceProfile->primary_color ?? '#040418ff';
            $secondaryColor = $workspaceProfile->accent_color ?? '#0a174dff';
            $backgroundColor = $workspaceProfile->background_color ?? '#f4f6fb';
            $textColor = $workspaceProfile->text_color ?? '#0f172a';
            $primaryRgb = [
                hexdec(substr($primaryColor, 1, 2)),
                hexdec(substr($primaryColor, 3, 2)),
                hexdec(substr($primaryColor, 5, 2)),
            ];
            $companyLogo = null;
            if ($workspaceForLayout?->created_by) {
                $companySettings = getCompanyAllSetting($workspaceForLayout->created_by, $workspaceForLayout->id);
                $logoCandidate = null;
                if (!empty($companySettings['logo_light']) && check_file($companySettings['logo_light'])) {
                    $logoCandidate = get_file($companySettings['logo_light']);
                } elseif (!empty($companySettings['logo_dark']) && check_file($companySettings['logo_dark'])) {
                    $logoCandidate = get_file($companySettings['logo_dark']);
                }
                $companyLogo = $logoCandidate;
            }
            $logoUrl = $workspaceProfile && $workspaceProfile->logo_path
                ? asset(\Illuminate\Support\Facades\Storage::url($workspaceProfile->logo_path))
                : ($companyLogo ?? asset('uploads/logo/logo_light.png'));
            $workspaceSlug = $workspaceForLayout?->slug ?: 'workspace';
            $workspaceUrl = url($workspaceSlug === 'workspace' ? '/' : $workspaceSlug);
        ?>

        <style>
            :root {
                --guest-primary: <?php echo e($primaryColor); ?>;
                --guest-secondary: <?php echo e($secondaryColor); ?>;
            }

            body {
                background: <?php echo e($backgroundColor); ?>;
                color: <?php echo e($textColor); ?>;
            }

            .workspace-banner {
                background: linear-gradient(15deg, <?php echo e($primaryColor); ?>, <?php echo e($secondaryColor); ?>);
            }
        </style>
        
        <div class="min-h-screen flex flex-col items-center ">
         <div class="rounded-3xl bg-white/20 shadow-2xl border border-slate-900">    
         <div class="px-8 py-4 text-center workspace-banner">   <br>
            <div class="items-center flex gap-6 mb-4" style="justify-content: center;">
                <a href="<?php echo e($workspaceUrl); ?>" class="flex items-center gap-3">
                    <img src="<?php echo e($logoUrl); ?>" alt="logo" class="h-16 w-auto">
                </a>
            </div>
            <div class="text-white text-sm font-semibold"><?php echo e($workspaceForLayout?->name ?? config('app.name')); ?></div>
            <?php if(!empty($workspaceProfile?->short_description)): ?>
                <p class="text-white/80 text-xs mt-1 max-w-[320px] mx-auto">
                    <?php echo e($workspaceProfile->short_description); ?>

                </p>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </div>
        </div>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/layouts/guest.blade.php ENDPATH**/ ?>