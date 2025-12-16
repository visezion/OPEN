<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Food Bank'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f5f6fb;
            margin: 0;
            padding: 0;
        }
        .page-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
            padding: 2rem;
        }
        .grid {
            display: grid;
            gap: 1rem;
        }
        .field label {
            font-weight: 600;
            display: block;
            margin-bottom: 0.35rem;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 1px solid #dde4f0;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        .field .radio-label {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-weight: 500;
        }
        .btn-wide {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 1.6rem;
            border-radius: 999px;
            background: #4338ca;
            color: #fff;
            border: none;
            font-size: 1rem;
            font-weight: 600;
        }
        .summary-grid {
            margin-top: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
        .summary-grid div {
            display: flex;
            justify-content: space-between;
            padding: 0.25rem 0;
            font-size: 0.95rem;
        }
        .admin-panel {
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            background: #fff;
        }
        .admin-panel h3 {
            margin: 0 0 0.75rem;
            font-size: 1.1rem;
        }
        .admin-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="card">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Providers/../Resources/views/public/layout.blade.php ENDPATH**/ ?>