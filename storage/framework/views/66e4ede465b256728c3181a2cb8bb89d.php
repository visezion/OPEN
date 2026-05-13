<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Openzion')); ?> - <?php echo e(__('Page Expired')); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-clean.css')); ?>">

    <style>
        body.expired-page {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.10), transparent 32%),
                linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
            color: #12243d;
            font-family: "Figtree", "Segoe UI", Roboto, Arial, sans-serif;
        }

        .expired-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .expired-card {
            width: min(560px, 100%);
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.10);
            padding: 32px 28px;
            text-align: center;
        }

        .expired-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            margin-bottom: 18px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 30px;
            font-weight: 800;
        }

        .expired-code {
            margin: 0 0 8px;
            font-size: 3rem;
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
        }

        .expired-title {
            margin: 0 0 12px;
            font-size: 1.75rem;
            line-height: 1.15;
            font-weight: 800;
            color: #12243d;
        }

        .expired-copy {
            margin: 0 auto;
            max-width: 420px;
            color: #5b6b84;
            line-height: 1.7;
        }

        .expired-help {
            margin: 18px 0 0;
            padding: 14px 16px;
            border-radius: 16px;
            background: #f8fafc;
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .expired-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .expired-actions .btn {
            min-width: 160px;
            border-radius: 12px;
        }

        @media (max-width: 640px) {
            .expired-card {
                padding: 26px 18px;
            }

            .expired-code {
                font-size: 2.4rem;
            }

            .expired-title {
                font-size: 1.45rem;
            }

            .expired-actions {
                flex-direction: column;
            }

            .expired-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body class="expired-page ui-border-clean">
    <div class="expired-wrap">
        <div class="expired-card">
            <div class="expired-badge">419</div>
            <p class="expired-code">419</p>
            <h1 class="expired-title"><?php echo e(__('Page Expired')); ?></h1>
            <p class="expired-copy">
                <?php echo e(__('Your session expired or the security token is no longer valid. Refresh the page and try the action again.')); ?>

            </p>

            <div class="expired-help">
                <?php echo e(__('This usually happens after staying on a form too long, opening the same page in multiple tabs, or submitting after signing out.')); ?>

            </div>

            <div class="expired-actions">
                <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary"><?php echo e(__('Go Back')); ?></a>
                <a href="<?php echo e(url()->current()); ?>" class="btn btn-primary"><?php echo e(__('Refresh Page')); ?></a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views/errors/419.blade.php ENDPATH**/ ?>