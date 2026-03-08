
<?php $__env->startSection('page-title', $page->id ? __('Edit Page') : __('Create Page')); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('cms.pages')); ?>"><?php echo e(__('Website Pages')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e($page->id ? __('Edit') : __('Create')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card"><div class="card-body">
<form method="POST" action="<?php echo e($page->id ? route('cms.pages.update',$page->id) : route('cms.pages.store')); ?>">
<?php echo csrf_field(); ?>
<div class="row">
  <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Title')); ?></label>
    <input type="text" name="title" class="form-control" value="<?php echo e(old('title',$page->title)); ?>" required></div>
  <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Slug')); ?></label>
    <input type="text" name="slug" class="form-control" value="<?php echo e(old('slug',$page->slug)); ?>" required></div>
  <div class="col-md-3 mb-3 form-check form-switch">
    <input type="checkbox" name="is_home" class="form-check-input" value="1" <?php echo e($page->is_home ? 'checked' : ''); ?>> <?php echo e(__('Home page')); ?>

  </div>
  <div class="col-md-3 mb-3 form-check form-switch">
    <input type="checkbox" name="is_published" class="form-check-input" value="1" <?php echo e(($page->id ? $page->is_published : true) ? 'checked' : ''); ?>> <?php echo e(__('Published')); ?>

  </div>
  <div class="col-md-3 mb-3"><label class="form-label"><?php echo e(__('Sort Order')); ?></label>
    <input type="number" name="sort_order" class="form-control" value="<?php echo e(old('sort_order',$page->sort_order ?? 0)); ?>"></div>
  <div class="col-md-12 text-end"><button class="btn btn-primary"><?php echo e(__('Save Page')); ?></button></div>
</div>
</form>
<?php if($page->id): ?>
<hr>
<h6 class="mt-3"><?php echo e(__('Sections')); ?></h6>
<form method="POST" action="<?php echo e(route('cms.pages.sections',$page->id)); ?>"><?php echo csrf_field(); ?>
<div class="d-flex gap-2 mb-2">
  <div class="dropdown">
    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="ti ti-plus"></i> <?php echo e(__('Add Section')); ?>

    </button>
    <ul class="dropdown-menu" id="sectionLibrary">
      <li><a class="dropdown-item add-type" data-type="hero" href="#">Hero</a></li>
      <li><a class="dropdown-item add-type" data-type="text" href="#">Text</a></li>
      <li><a class="dropdown-item add-type" data-type="gallery" href="#">Gallery</a></li>
      <li><a class="dropdown-item add-type" data-type="cta" href="#">Call To Action</a></li>
      <li><a class="dropdown-item add-type" data-type="events" href="#">Events List</a></li>
      <li><a class="dropdown-item add-type" data-type="sermon" href="#">Sermon/Video</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item add-type" data-type="custom" href="#">Custom (advanced)</a></li>
    </ul>
  </div>
  <button class="btn btn-primary btn-sm" type="submit"><?php echo e(__('Save Sections')); ?></button>
  <span class="small text-muted align-self-center"><?php echo e(__('Drag rows to reorder. No JSON needed — fields per type.')); ?></span>
  <div class="ms-auto"></div>
  <div class="form-check form-switch align-self-center">
    <input class="form-check-input" type="checkbox" id="toggleDetails" checked>
    <label class="form-check-label" for="toggleDetails"><?php echo e(__('Show details')); ?></label>
  </div>
  </div>

<table class="table align-middle" id="sectionsTable"><thead><tr>
<th style="width:120px"><?php echo e(__('Type')); ?></th>
<th style="width:220px"><?php echo e(__('Title')); ?></th>
<th><?php echo e(__('Content')); ?></th>
<th style="width:90px" class="text-center"><?php echo e(__('Active')); ?></th>
<th style="width:40px"></th>
</tr></thead><tbody>
<?php $i=0; ?>
<?php $__currentLoopData = ($sections ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $t = $s->type; $c = is_array($s->content) ? $s->content : (json_decode($s->content,true) ?: []); ?>
<tr>
  <td>
    <select name="sections[<?php echo e($i); ?>][type]" class="form-select section-type">
      <?php $__currentLoopData = ['hero','text','gallery','cta','events','sermon','custom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($opt); ?>" <?php echo e($t===$opt?'selected':''); ?>><?php echo e(ucfirst($opt)); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </td>
  <td><input type="text" name="sections[<?php echo e($i); ?>][title]" class="form-control" value="<?php echo e($s->title); ?>" placeholder="<?php echo e(__('Optional title')); ?>"></td>
  <td class="content-cell">
    
    <?php echo $__env->make('churchly::cms.section_fields', ['idx'=>$i, 'type'=>$t, 'content'=>$c], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </td>
  <td class="text-center"><input type="checkbox" name="sections[<?php echo e($i); ?>][active]" value="1" <?php echo e($s->active ? 'checked' : ''); ?>></td>
  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row" title="<?php echo e(__('Remove')); ?>">&times;</button></td>
</tr>
<?php $i++; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table>
</form>
<?php endif; ?>
</div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const table = document.getElementById('sectionsTable');
  const lib = document.getElementById('sectionLibrary');
  lib?.addEventListener('click', function(e){
    const a = e.target.closest('.add-type'); if(!a) return;
    e.preventDefault();
    addSectionRow(a.dataset.type || 'text');
  });
  table?.addEventListener('click', function(e){ if(e.target.closest('.remove-row')) e.target.closest('tr').remove(); });
  table?.addEventListener('change', function(e){
    const sel = e.target.closest('.section-type');
    if(sel){
      const tr = sel.closest('tr');
      const idx = Array.from(table.tBodies[0].rows).indexOf(tr);
      const cell = tr.querySelector('.content-cell');
      cell.innerHTML = renderFields(sel.value, idx);
    }
  });
  document.getElementById('toggleDetails')?.addEventListener('change', function(){
    document.querySelectorAll('.section-details').forEach(el=>{
      el.style.display = this.checked ? '' : 'none';
    });
  });

  function addSectionRow(type){
    const idx = table.tBodies[0].rows.length;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <select name="sections[${idx}][type]" class="form-select section-type">
          ${['hero','text','gallery','cta','events','sermon','custom'].map(opt=>`<option value="${opt}" ${opt===type?'selected':''}>${opt.charAt(0).toUpperCase()+opt.slice(1)}</option>`).join('')}
        </select>
      </td>
      <td><input type="text" name="sections[${idx}][title]" class="form-control" placeholder="${'<?php echo e(__('Optional title')); ?>'}"></td>
      <td class="content-cell">${renderFields(type, idx)}</td>
      <td class="text-center"><input type="checkbox" name="sections[${idx}][active]" value="1" checked></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>`;
    table.tBodies[0].appendChild(tr);
  }

  function renderFields(type, idx){
    switch(type){
      case 'hero':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][title_text]" placeholder="Title"></div>
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][subtitle]" placeholder="Subtitle"></div>
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][background_image]" placeholder="Background image URL"></div>
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][button_text]" placeholder="Button text"></div>
            <div class="col-md-8"><input class="form-control" name="sections[${idx}][button_link]" placeholder="Button link URL"></div>
          </div>`;
      case 'text':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][heading]" placeholder="Heading"></div>
            <div class="col-md-8"><textarea class="form-control" rows="2" name="sections[${idx}][body]" placeholder="Body"></textarea></div>
            <div class="col-md-3"><select class="form-select" name="sections[${idx}][align]"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></div>
          </div>`;
      case 'gallery':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-12"><textarea class="form-control" rows="2" name="sections[${idx}][images_text]" placeholder="One image URL per line"></textarea></div>
          </div>`;
      case 'cta':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-4"><input class="form-control" name="sections[${idx}][title_text]" placeholder="Title"></div>
            <div class="col-md-5"><input class="form-control" name="sections[${idx}][text]" placeholder="Text"></div>
            <div class="col-md-3"><input class="form-control" name="sections[${idx}][link_text]" placeholder="Link text"></div>
            <div class="col-md-12"><input class="form-control" name="sections[${idx}][link_url]" placeholder="Link URL"></div>
          </div>`;
      case 'events':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-3"><input type="number" min="1" class="form-control" name="sections[${idx}][limit]" placeholder="Limit (e.g., 5)"></div>
            <div class="col-md-3 form-check form-switch"><input class="form-check-input" type="checkbox" name="sections[${idx}][show_past]"> Show past</div>
          </div>`;
      case 'sermon':
        return `
          <div class="row g-2 section-details">
            <div class="col-md-6"><input class="form-control" name="sections[${idx}][video_url]" placeholder="Video URL (YouTube/Vimeo)"></div>
            <div class="col-md-6"><input class="form-control" name="sections[${idx}][title_text]" placeholder="Title"></div>
          </div>`;
      default:
        return `<div class="text-muted small"><?php echo e(__('Custom section: use above Title and Active; content can be extended later.')); ?></div>`;
    }
  }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.querySelector('#sectionsTable tbody');
  if(!tbody) return;
  Sortable.create(tbody,{ animation:150 });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\page_edit.blade.php ENDPATH**/ ?>