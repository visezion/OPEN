<?php
  $i = $idx ?? 0; $t = $type ?? 'banner_carousel'; $c = $settings ?? [];
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($t):
  case ('banner_carousel'): ?>
    <div class="row g-2">
      <div class="col-md-8"><textarea class="form-control" rows="2" name="widgets[<?php echo e($i); ?>][images_text]" placeholder="One image URL per line"><?php echo e(isset($c['images']) && is_array($c['images']) ? implode("\n", $c['images']) : ''); ?></textarea></div>
      <div class="col-md-2 form-check form-switch">
        <input class="form-check-input" type="checkbox" name="widgets[<?php echo e($i); ?>][autoplay]" value="1" <?php echo e(!empty($c['autoplay']) ? 'checked' : ''); ?>> Autoplay
      </div>
      <div class="col-md-2"><input type="number" class="form-control" name="widgets[<?php echo e($i); ?>][interval]" value="<?php echo e($c['interval'] ?? 3000); ?>" placeholder="3000"></div>
    </div>
    <?php break; ?>
  <?php case ('quick_links'): ?>
    <div class="row g-2">
      <div class="col-md-12"><textarea class="form-control" rows="2" name="widgets[<?php echo e($i); ?>][links_text]" placeholder="Title|ti ti-icon|target per line"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($c['links']) && is_array($c['links'])): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $c['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e(($l['title']??'')); ?>|<?php echo e(($l['icon_name']??'')); ?>|<?php echo e(($l['target']??'')); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></textarea></div>
    </div>
    <?php break; ?>
  <?php case ('latest_sermons'): ?>
    <div class="row g-2">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[<?php echo e($i); ?>][limit]" value="<?php echo e($c['limit'] ?? 5); ?>" placeholder="Limit"></div>
      <div class="col-md-9"><input class="form-control" name="widgets[<?php echo e($i); ?>][source]" value="<?php echo e($c['source'] ?? ''); ?>" placeholder="Playlist/Channel ID (optional)"></div>
    </div>
    <?php break; ?>
  <?php case ('upcoming_events'): ?>
    <div class="row g-2">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[<?php echo e($i); ?>][limit]" value="<?php echo e($c['limit'] ?? 5); ?>" placeholder="Limit"></div>
      <div class="col-md-3 form-check form-switch"><input class="form-check-input" type="checkbox" name="widgets[<?php echo e($i); ?>][show_past]" value="1" <?php echo e(!empty($c['show_past']) ? 'checked' : ''); ?>> Show past</div>
    </div>
    <?php break; ?>
  <?php case ('custom_html'): ?>
  <?php default: ?>
    <textarea class="form-control" rows="3" name="widgets[<?php echo e($i); ?>][html]" placeholder="&lt;div&gt;...&lt;/div&gt;"><?php echo e($c['html'] ?? ''); ?></textarea>
<?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\widget_fields.blade.php ENDPATH**/ ?>