<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module $STUDLY_NAME$</title>

       
       

    </head>
    <body>
        <?php
    $company_settings = [];

    if (Auth::check()) {
        $creatorId = creatorId();
        $company_settings = getCompanyAllSetting($creatorId);
    }

    $color = $company_settings['color'] ?? 'theme-1';
    $themeColor = ($company_settings['color_flag'] ?? false) == 'true' ? 'custom-color' : $color;
?>


        <?php echo $__env->yieldContent('content'); ?>

        
        
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\layouts\guest.blade.php ENDPATH**/ ?>