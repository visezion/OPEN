<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
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
    <body class="font-sans antialiased ui-border-clean">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\layouts\app.blade.php ENDPATH**/ ?>