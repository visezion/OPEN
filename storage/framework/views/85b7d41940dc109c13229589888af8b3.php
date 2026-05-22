

<?php $__env->startSection('page-title', __('Edit Discipleship Stage')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
   
    <div class="col-sm-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-pencil text-primary"></i> <?php echo e(__('Edit Stage & Requirements')); ?></h5>

                <form action="<?php echo e(route('discipleship.update', $stage->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="fw-bold"><?php echo e(__('Stage Name')); ?></label>
                        <input type="text" name="name" value="<?php echo e($stage->name); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold"><?php echo e(__('Description')); ?></label>
                        <textarea name="description" class="form-control"><?php echo e($stage->description); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold"><?php echo e(__('Order')); ?></label>
                        <input type="number" name="order" value="<?php echo e($stage->order); ?>" class="form-control">
                    </div>

                    <hr>
                    <h6><?php echo e(__('Requirements')); ?></h6>
                    <div id="requirements">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="requirement-block mb-3 border p-3 rounded">
                                <input type="hidden" name="requirements[<?php echo e($i); ?>][id]" value="<?php echo e($req->id); ?>">

                                <input type="text" name="requirements[<?php echo e($i); ?>][title]" class="form-control mb-2"
                                    value="<?php echo e($req->title); ?>" placeholder="Requirement Title">

                                <select name="requirements[<?php echo e($i); ?>][type]" class="form-select mb-2">
                                    <option value="attendance" <?php echo e($req->type=='attendance'?'selected':''); ?>>Attendance</option>
                                    <option value="quiz" <?php echo e($req->type=='quiz'?'selected':''); ?>>Quiz</option>
                                    <option value="file_upload" <?php echo e($req->type=='file_upload'?'selected':''); ?>>File Upload</option>
                                    <option value="mentor_approval" <?php echo e($req->type=='mentor_approval'?'selected':''); ?>>Mentor Approval</option>
                                    <option value="self_check" <?php echo e($req->type=='self_check'?'selected':''); ?>>Self Check</option>
                                    <option value="custom_text" <?php echo e($req->type=='custom_text'?'selected':''); ?>>Text/Testimony</option>
                                </select>

                                <textarea name="requirements[<?php echo e($i); ?>][description]" class="form-control mb-2"
                                    placeholder="Requirement Description"><?php echo e($req->description); ?></textarea>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="requirements[<?php echo e($i); ?>][is_mandatory]" <?php echo e($req->is_mandatory ? 'checked' : ''); ?>>
                                            <span class="form-check-label"><?php echo e(__('Mandatory')); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-check">
                                            <input type="checkbox" name="requirements[<?php echo e($i); ?>][requires_approval]" <?php echo e($req->requires_approval ? 'checked' : ''); ?>>
                                            <span class="form-check-label"><?php echo e(__('Requires Approval')); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="requirements[<?php echo e($i); ?>][points]"
                                            value="<?php echo e($req->points); ?>" class="form-control form-control-sm"
                                            placeholder="Points (e.g., 10)">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mb-3" id="add-requirement">
                        <i class="ti ti-plus"></i> <?php echo e(__('Add Requirement')); ?>

                    </button>

                    <button class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy"></i> <?php echo e(__('Save Changes')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> <?php echo e(__('Editing Help')); ?></h6>
                <p class="small text-muted">
                    <?php echo e(__('Here you can update the stage details and manage requirements. You may add new requirements, edit existing ones, or remove them.')); ?>

                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let reqIndex = <?php echo e($stage->requirements->count()); ?>;

    document.getElementById("add-requirement").addEventListener("click", function() {
        let container = document.getElementById("requirements");

        let block = document.createElement("div");
        block.classList.add("requirement-block","mb-3","border","p-3","rounded");

        block.innerHTML = `
            <input type="text" name="requirements[${reqIndex}][title]" class="form-control mb-2"
                placeholder="Requirement Title">

            <select name="requirements[${reqIndex}][type]" class="form-select mb-2">
                <option value="attendance">Attendance</option>
                <option value="quiz">Quiz</option>
                <option value="file_upload">File Upload</option>
                <option value="mentor_approval">Mentor Approval</option>
                <option value="self_check">Self Check</option>
                <option value="custom_text">Text/Testimony</option>
            </select>

            <textarea name="requirements[${reqIndex}][description]" class="form-control mb-2"
                placeholder="Requirement Description"></textarea>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-check">
                        <input type="checkbox" name="requirements[${reqIndex}][is_mandatory]">
                        <span class="form-check-label"><?php echo e(__('Mandatory')); ?></span>
                    </label>
                </div>
                <div class="col-md-4">
                    <label class="form-check">
                        <input type="checkbox" name="requirements[${reqIndex}][requires_approval]">
                        <span class="form-check-label"><?php echo e(__('Requires Approval')); ?></span>
                    </label>
                </div>
                <div class="col-md-4">
                    <input type="number" name="requirements[${reqIndex}][points]"
                        class="form-control form-control-sm" placeholder="Points (e.g., 10)">
                </div>
            </div>
        `;

        container.appendChild(block);
        reqIndex++;
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\edit.blade.php ENDPATH**/ ?>