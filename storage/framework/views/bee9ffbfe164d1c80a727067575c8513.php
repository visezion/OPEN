<form method="POST" action="<?php echo e(route('app-builder.saveLayout')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="screen_key" value="home">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label"><?php echo e(__('Screen Title')); ?></label>
            <input type="text" name="title" class="form-control" value="<?php echo e($homeLayout->title); ?>" placeholder="Home">
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary mt-4" type="submit"><?php echo e(__('Save Layout')); ?></button>
        </div>
    </div>

    <table class="table align-middle">
        <thead>
            <tr>
                <th style="width:22%"><?php echo e(__('Type')); ?></th>
                <th style="width:22%"><?php echo e(__('Title')); ?></th>
                <th style="width:40%"><?php echo e(__('Settings (JSON)')); ?></th>
                <th style="width:10%"><?php echo e(__('Active')); ?></th>
                <th style="width:6%"></th>
            </tr>
        </thead>
        <tbody id="widgetsTable">
            <?php $__empty_1 = true; $__currentLoopData = $homeWidgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="sortable-item">
                <td>
                    <select name="widgets[<?php echo e($i); ?>][type]" class="form-select">
                        <?php $types = ['banner_carousel','quick_links','latest_sermons','upcoming_events','custom_html']; ?>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>" <?php echo e($w->type==$t ? 'selected':''); ?>><?php echo e($t); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="widgets[<?php echo e($i); ?>][title]" class="form-control" value="<?php echo e($w->title); ?>">
                </td>
                <td>
                    <textarea name="widgets[<?php echo e($i); ?>][settings]" class="form-control" rows="2"><?php echo e(json_encode($w->settings)); ?></textarea>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="widgets[<?php echo e($i); ?>][active]" value="1" <?php echo e($w->active ? 'checked' : ''); ?>>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </tbody>
    </table>

    <button type="button" id="addWidgetBtn" class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-plus"></i> <?php echo e(__('Add Widget')); ?>

    </button>

    <div class="text-end mt-3">
        <button class="btn btn-primary" type="submit"><?php echo e(__('Save Layout')); ?></button>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  Sortable.create(document.getElementById('widgetsTable'), { animation: 150 });

  function newRow(index) {
    return `
      <tr class="sortable-item">
        <td>
          <select name="widgets[${index}][type]" class="form-select">
            <option value="banner_carousel">banner_carousel</option>
            <option value="quick_links">quick_links</option>
            <option value="latest_sermons">latest_sermons</option>
            <option value="upcoming_events">upcoming_events</option>
            <option value="custom_html">custom_html</option>
          </select>
        </td>
        <td><input type="text" name="widgets[${index}][title]" class="form-control" placeholder="Section title"></td>
        <td><textarea name="widgets[${index}][settings]" class="form-control" rows="2" placeholder='{"limit": 5}'></textarea></td>
        <td class="text-center"><input type="checkbox" name="widgets[${index}][active]" value="1" checked></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>
      </tr>`;
  }

  document.getElementById('addWidgetBtn').addEventListener('click', function(){
    const tbody = document.getElementById('widgetsTable');
    const idx = tbody.children.length;
    tbody.insertAdjacentHTML('beforeend', newRow(idx));
  });

  document.getElementById('widgetsTable').addEventListener('click', function(e){
    if (e.target.closest('.remove-row')) {
      e.target.closest('tr').remove();
    }
  });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\_layout.blade.php ENDPATH**/ ?>