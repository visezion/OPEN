<form method="POST" action="<?php echo e(route('app-builder.saveMenu')); ?>">
    <?php echo csrf_field(); ?>
    <div id="menuBuilderContainer">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th><?php echo e(__('Title')); ?></th>
                    <th><?php echo e(__('Feature')); ?></th>
                    <th><?php echo e(__('Icon')); ?></th>
                    <th><?php echo e(__('Visible')); ?></th>
                </tr>
            </thead>
            <tbody id="sortableMenu">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="sortable-item">
                        <td>
                            <input type="text" class="form-control" name="menu[<?php echo e($loop->index); ?>][title]" value="<?php echo e($item->title); ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="menu[<?php echo e($loop->index); ?>][feature_key]" value="<?php echo e($item->feature_key); ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="menu[<?php echo e($loop->index); ?>][icon_name]" value="<?php echo e($item->icon_name); ?>">
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="menu[<?php echo e($loop->index); ?>][visible]" value="1" <?php echo e($item->visible ? 'checked' : ''); ?>>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <button type="button" class="btn btn-outline-secondary btn-sm" id="addRowBtn">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Item')); ?>

        </button>
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary"><?php echo e(__('Save Menu Layout')); ?></button>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Sortable.create(document.getElementById('sortableMenu'), { animation: 150 });

    document.getElementById('addRowBtn').addEventListener('click', function(){
        const tbody = document.getElementById('sortableMenu');
        const index = tbody.children.length;
        tbody.insertAdjacentHTML('beforeend', `
            <tr class="sortable-item">
                <td><input type="text" name="menu[${index}][title]" class="form-control" placeholder="Title"></td>
                <td><input type="text" name="menu[${index}][feature_key]" class="form-control" placeholder="Feature"></td>
                <td><input type="text" name="menu[${index}][icon_name]" class="form-control" placeholder="Icon"></td>
                <td><input class="form-check-input" type="checkbox" name="menu[${index}][visible]" value="1" checked></td>
            </tr>
        `);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\_menu.blade.php ENDPATH**/ ?>