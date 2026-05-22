<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
       

        <?php if (app('laratrust')->hasPermission('church_branch manage')) : ?>
            <a href="<?php echo e(route('churchbranch.index')); ?>"
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchbranch.*') ? 'active' : ''); ?>">
                <?php echo e(__('Branch')); ?>

                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
            </a>
        <?php endif; // app('laratrust')->permission ?>


        <?php if (app('laratrust')->hasPermission('church_department manage')) : ?>
            <a href="<?php echo e(route('churchly.departments.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchly.*') ? 'active' : ''); ?>"><?php echo e(__('Departments')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('church_volunteer manage')) : ?>
            <a href="<?php echo e(route('churchly.volunteers.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchly.volunteers.*') ? 'active' : ''); ?>"><?php echo e(__('Volunteers')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('church_household manage')) : ?>
            <a href="<?php echo e(route('churchly.households.index')); ?>"
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchly.households.*') ? 'active' : ''); ?>"><?php echo e(__('Households')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('church_settings manage')) : ?>
            <a href="<?php echo e(route('churchly.zoom.index')); ?>"
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchly.zoom.*') ? 'active' : ''); ?>"><?php echo e(__('Zoon Integration')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>


        <?php if (app('laratrust')->hasPermission('church_designation manage')) : ?>
            <a href="<?php echo e(route('churchdesignation.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('churchdesignation.*') ? 'active' : ''); ?>"><?php echo e(__('Designation')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('church_documenttype manage')) : ?>
            <a href="<?php echo e(route('zender.whatsapp.groups')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('zender.*') ? 'active' : ''); ?>"><?php echo e(__('Document Type')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
       
        <?php if (app('laratrust')->hasPermission('church_settings manage')) : ?>
            <a href="<?php echo e(route('wa_group.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('wa_group.*') ? 'active' : ''); ?>"><?php echo e(__('Assign WhatsApp Group')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        <a href="<?php echo e(route('formsetup.index')); ?>" 
        class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('formsetup.*') ? 'active' : ''); ?>"><?php echo e(__('Custom Member Form')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>    
        <?php if (app('laratrust')->hasPermission('church_settings manage')) : ?>
            <a href="<?php echo e(route('sms-gateway.edit')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('sms-gateway.*') ? 'active' : ''); ?>"><?php echo e(__('SMS Gateway Settings')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        <?php if (app('laratrust')->hasPermission('church_settings manage')) : ?>
            <a href="<?php echo e(route('discipleship.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('discipleship.*') ? 'active' : ''); ?>"><?php echo e(__('Setup Discipleship Pathway')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('church_settings manage')) : ?>
            <a href="<?php echo e(route('birthday_templates.index')); ?>" 
            class="list-group-item list-group-item-action border-0 <?php echo e(request()->routeIs('birthday_templates.*') ? 'active' : ''); ?>"><?php echo e(__('Birthday Templates')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        <?php endif; // app('laratrust')->permission ?>
        
   
       
       
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\layouts\churchly_setup.blade.php ENDPATH**/ ?>