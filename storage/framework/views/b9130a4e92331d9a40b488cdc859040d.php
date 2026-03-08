<?php
  $i = $idx ?? 0; $t = $type ?? 'text'; $c = $content ?? [];
?>
<?php switch($t):
  case ('hero'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][title_text]" value="<?php echo e($c['title_text'] ?? ''); ?>" placeholder="Title"></div>
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][subtitle]" value="<?php echo e($c['subtitle'] ?? ''); ?>" placeholder="Subtitle"></div>
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][background_image]" value="<?php echo e($c['background_image'] ?? ''); ?>" placeholder="Background image URL"></div>
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][button_text]" value="<?php echo e($c['button_text'] ?? ''); ?>" placeholder="Button text"></div>
      <div class="col-md-8"><input class="form-control" name="sections[<?php echo e($i); ?>][button_link]" value="<?php echo e($c['button_link'] ?? ''); ?>" placeholder="Button link URL"></div>
    </div>
    <?php break; ?>
  <?php case ('text'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][heading]" value="<?php echo e($c['heading'] ?? ''); ?>" placeholder="Heading"></div>
      <div class="col-md-8"><textarea class="form-control" rows="2" name="sections[<?php echo e($i); ?>][body]" placeholder="Body"><?php echo e($c['body'] ?? ''); ?></textarea></div>
      <div class="col-md-3">
        <select class="form-select" name="sections[<?php echo e($i); ?>][align]">
          <?php $__currentLoopData = ['left','center','right']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($opt); ?>" <?php echo e(($c['align'] ?? 'left')===$opt?'selected':''); ?>><?php echo e(ucfirst($opt)); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
    </div>
    <?php break; ?>
  <?php case ('gallery'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-12">
        <textarea class="form-control" rows="2" name="sections[<?php echo e($i); ?>][images_text]" placeholder="One image URL per line"><?php echo e(isset($c['images']) && is_array($c['images']) ? implode("\n", $c['images']) : ''); ?></textarea>
      </div>
    </div>
    <?php break; ?>
  <?php case ('cta'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-4"><input class="form-control" name="sections[<?php echo e($i); ?>][title_text]" value="<?php echo e($c['title_text'] ?? ''); ?>" placeholder="Title"></div>
      <div class="col-md-5"><input class="form-control" name="sections[<?php echo e($i); ?>][text]" value="<?php echo e($c['text'] ?? ''); ?>" placeholder="Text"></div>
      <div class="col-md-3"><input class="form-control" name="sections[<?php echo e($i); ?>][link_text]" value="<?php echo e($c['link_text'] ?? ''); ?>" placeholder="Link text"></div>
      <div class="col-md-12"><input class="form-control" name="sections[<?php echo e($i); ?>][link_url]" value="<?php echo e($c['link_url'] ?? ''); ?>" placeholder="Link URL"></div>
    </div>
    <?php break; ?>
  <?php case ('events'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-3"><input type="number" min="1" class="form-control" name="sections[<?php echo e($i); ?>][limit]" value="<?php echo e($c['limit'] ?? 5); ?>" placeholder="Limit"></div>
      <div class="col-md-3 form-check form-switch">
        <input class="form-check-input" type="checkbox" name="sections[<?php echo e($i); ?>][show_past]" value="1" <?php echo e(!empty($c['show_past']) ? 'checked' : ''); ?>> Show past
      </div>
    </div>
    <?php break; ?>
  <?php case ('sermon'): ?>
    <div class="row g-2 section-details">
      <div class="col-md-6"><input class="form-control" name="sections[<?php echo e($i); ?>][video_url]" value="<?php echo e($c['video_url'] ?? ''); ?>" placeholder="Video URL (YouTube/Vimeo)"></div>
      <div class="col-md-6"><input class="form-control" name="sections[<?php echo e($i); ?>][title_text]" value="<?php echo e($c['title_text'] ?? ''); ?>" placeholder="Title"></div>
    </div>
    <?php break; ?>
  <?php default: ?>
    <div class="text-muted small"><?php echo e(__('Custom section: use Title and Active; extend later as needed.')); ?></div>
<?php endswitch; ?>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\section_fields.blade.php ENDPATH**/ ?>