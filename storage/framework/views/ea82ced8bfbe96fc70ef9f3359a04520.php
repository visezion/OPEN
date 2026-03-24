<?php
    $modules = getshowModuleList();
?>
<ul class="nav nav-pills nav-fill cust-nav information-tab mb-4" id="pills-tab" role="tablist">
    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="nav-item">
            <a class="nav-link text-capitalize <?php echo e(( $slug == ($module)) ? ' active' : ''); ?> " href="<?php echo e(route('marketplace.index', ($module))); ?>"><?php echo e(Module_Alias_Name($module)); ?></a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\LandingPage\src\Resources\views\marketplace\modules.blade.php ENDPATH**/ ?>