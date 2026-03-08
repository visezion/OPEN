<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('page-title', 'Church System'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <div class="container mt-5">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\layouts\public.blade.php ENDPATH**/ ?>