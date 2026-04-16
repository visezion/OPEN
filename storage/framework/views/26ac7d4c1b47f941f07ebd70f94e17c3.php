<?php $__env->startSection('page-title', __('Website Pages')); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Website Pages')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
  <a href="<?php echo e(route('cms.pages.create')); ?>" class="btn btn-sm btn-primary"><i class="ti ti-plus"></i> <?php echo e(__('New Page')); ?></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card"><div class="card-body">
<table class="table align-middle"><thead><tr>
<th><?php echo e(__('Title')); ?></th><th><?php echo e(__('Slug')); ?></th><th><?php echo e(__('Home')); ?></th><th><?php echo e(__('Published')); ?></th><th><?php echo e(__('Order')); ?></th><th></th>
</tr></thead><tbody>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>
  <td><?php echo e($p->title); ?></td>
  <td><?php echo e($p->slug); ?></td>
  <td><?php echo e($p->is_home ? 'Yes':'No'); ?></td>
  <td><?php echo e($p->is_published ? 'Yes':'No'); ?></td>
  <td><?php echo e($p->sort_order); ?></td>
  <td>
    <a href="<?php echo e(route('cms.pages.edit',$p->id)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
    <form method="POST" action="<?php echo e(route('cms.pages.delete',$p->id)); ?>" style="display:inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
      <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete page?')"><?php echo e(__('Delete')); ?></button>
    </form>
  </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="6" class="text-center text-muted"><?php echo e(__('No pages yet')); ?></td></tr>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</tbody></table>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.querySelector('table tbody');
  if(!tbody) return;
  Sortable.create(tbody,{ animation:150 });
  const saveBtn = document.createElement('button');
  saveBtn.className='btn btn-sm btn-outline-secondary';
  saveBtn.innerText='Save Order';
  saveBtn.addEventListener('click', function(){
    const ids=[]; tbody.querySelectorAll('tr').forEach(tr=>{ const id = tr.querySelector('a[href*="/edit"]')?.getAttribute('href')?.match(/\/(\d+)\/edit/); if(id){ ids.push(id[1]); } });
    const form=document.createElement('form'); form.method='POST'; form.action='<?php echo e(route('cms.pages.sort')); ?>';
    form.innerHTML='<?php echo csrf_field(); ?>'+ids.map(i=>`<input type="hidden" name="order[]" value="${i}">`).join('');
    document.body.appendChild(form); form.submit();
  });
  document.querySelector('.card-body')?.prepend(saveBtn);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\pages.blade.php ENDPATH**/ ?>