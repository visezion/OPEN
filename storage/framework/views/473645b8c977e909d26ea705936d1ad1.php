<?php $__env->startSection('page-title', __('Website Menu')); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('cms.pages')); ?>"><?php echo e(__('Website CMS')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Menu')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card"><div class="card-body">
<form method="POST" action="<?php echo e(route('cms.menu.save')); ?>" id="menuForm"><?php echo csrf_field(); ?>
<div class="mb-3"><label class="form-label"><?php echo e(__('Menu Title')); ?></label><input type="text" name="title" class="form-control" value="<?php echo e($menu->title); ?>"></div>
<table class="table align-middle" id="menuTable"><thead><tr><th><?php echo e(__('Title')); ?></th><th><?php echo e(__('Slug/URL')); ?></th><th></th></tr></thead><tbody>
<?php $items = $menu->items ?? []; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
  <td><input type="text" class="form-control" value="<?php echo e($it['title'] ?? ''); ?>" data-field="title"></td>
  <td><input type="text" class="form-control" value="<?php echo e($it['slug'] ?? ($it['url'] ?? '')); ?>" data-field="link"></td>
  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</tbody></table>
<button type="button" id="addItem" class="btn btn-outline-secondary btn-sm"><i class="ti ti-plus"></i> <?php echo e(__('Add Item')); ?></button>
<input type="hidden" name="items" id="itemsJson">
<div class="text-end mt-3"><button class="btn btn-primary"><?php echo e(__('Save Menu')); ?></button></div>
</form>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.querySelector('#menuTable tbody');
  Sortable.create(tbody,{ animation:150 });
  document.getElementById('addItem').addEventListener('click', function(){
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><input type="text" class="form-control" data-field="title" placeholder="Home"></td>
                  <td><input type="text" class="form-control" data-field="link" placeholder="/ or about"></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>`;
    tbody.appendChild(tr);
  });
  tbody.addEventListener('click', function(e){ if(e.target.closest('.remove-row')) e.target.closest('tr').remove(); });
  document.getElementById('menuForm').addEventListener('submit', function(){
    const items=[]; tbody.querySelectorAll('tr').forEach(tr=>{ items.push({ title: tr.querySelector('[data-field="title"]').value, slug: tr.querySelector('[data-field="link"]').value }); });
    document.getElementById('itemsJson').value = JSON.stringify(items);
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\menu.blade.php ENDPATH**/ ?>