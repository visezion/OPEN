

<?php $__env->startSection('page-title', __('Edit Template Visually')); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .template-canvas {
        position: relative;
        display: inline-block;
        border: 2px solid #ddd;
        overflow: hidden;
    }
    .template-bg {
        display: block;
        width: 100%;
        height: auto;
    }
    .draggable {
        position: absolute;
        cursor: grab;
        user-select: none;
        z-index: 10;
    }
    .draggable:active {
        cursor: grabbing;
    }
    .photo-placeholder {
        border-radius: 50%;
        border: 3px dashed #007bff;
        overflow: hidden;
        background: #eee;
        width: <?php echo e($template->photo_width ?? 150); ?>px;
        height: <?php echo e($template->photo_height ?? 150); ?>px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .photo-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .text-placeholder {
        font-size: 22px;
        font-weight: bold;
        color: #000;
        white-space: nowrap;
        background: rgba(255,255,255,0.2);
        padding: 2px 6px;
        border-radius: 4px;
    }
    .slogan-placeholder {
        font-size: 16px;
        font-weight: normal;
        color: #444;
        white-space: nowrap;
        background: rgba(255,255,255,0.2);
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0">
    <div class="card-body text-center">
        <h5 class="mb-3">Drag & Drop to Set Positions</h5>

        <div class="template-canvas" id="canvas">
            <!-- Background Template -->
            <img src="<?php echo e(asset('storage/'.$template->file_path)); ?>" class="template-bg" alt="Template">

            <!-- Profile photo placeholder -->
            <div id="photo" class="draggable photo-placeholder"
                style="top:<?php echo e($template->photo_y ?? 100); ?>px; left:<?php echo e($template->photo_x ?? 100); ?>px;">
                <img src="<?php echo e(asset('images/avatar-sample.png')); ?>" alt="Avatar">
            </div>

            <!-- Name placeholder -->
            <div id="name" class="draggable text-placeholder"
                style="top:<?php echo e($template->name_y ?? 300); ?>px; left:<?php echo e($template->name_x ?? 100); ?>px;">
                Min. SAMPLE NAME
            </div>

            <!-- Slogan placeholder -->
            <div id="slogan" class="draggable slogan-placeholder"
                style="top:<?php echo e($template->slogan_y ?? 360); ?>px; left:<?php echo e($template->slogan_x ?? 100); ?>px;">
                This is your year of recovery...
            </div>
        </div>

        <!-- Save Form -->
        <form action="<?php echo e(route('birthday_templates.update', $template->id)); ?>" method="POST" class="mt-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="hidden" id="photo_x" name="photo_x" value="<?php echo e($template->photo_x); ?>">
            <input type="hidden" id="photo_y" name="photo_y" value="<?php echo e($template->photo_y); ?>">
            <input type="hidden" id="name_x" name="name_x" value="<?php echo e($template->name_x); ?>">
            <input type="hidden" id="name_y" name="name_y" value="<?php echo e($template->name_y); ?>">
            <input type="hidden" id="slogan_x" name="slogan_x" value="<?php echo e($template->slogan_x); ?>">
            <input type="hidden" id="slogan_y" name="slogan_y" value="<?php echo e($template->slogan_y); ?>">

            <button type="submit" class="btn btn-primary mt-3">Save Positions</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.querySelectorAll('.draggable').forEach(el => {
        el.addEventListener('mousedown', function(e) {
            e.preventDefault();
            const canvas = document.getElementById('canvas');
            let shiftX = e.clientX - el.getBoundingClientRect().left;
            let shiftY = e.clientY - el.getBoundingClientRect().top;

            function moveAt(pageX, pageY) {
                let newLeft = pageX - shiftX - canvas.getBoundingClientRect().left;
                let newTop = pageY - shiftY - canvas.getBoundingClientRect().top;

                el.style.left = newLeft + 'px';
                el.style.top = newTop + 'px';
            }

            function onMouseMove(event) {
                moveAt(event.pageX, event.pageY);
            }

            document.addEventListener('mousemove', onMouseMove);

            el.onmouseup = function () {
                document.removeEventListener('mousemove', onMouseMove);
                el.onmouseup = null;

                // Save instantly to hidden inputs
                document.getElementById(el.id + '_x').value = parseInt(el.style.left);
                document.getElementById(el.id + '_y').value = parseInt(el.style.top);
            };
        });

        el.ondragstart = () => false;
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\birthday_templates\edit.blade.php ENDPATH**/ ?>