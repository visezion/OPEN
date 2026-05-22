<?php echo Form::model($churchdesignation, [
    'route' => ['churchdesignation.update', $churchdesignation->id],
    'method' => 'PUT'
]); ?>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group mb-3">
                    <?php echo Form::label('name', __('Name'), ['class' => 'form-label']); ?>

                    <?php echo Form::text('name', null, [
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => __('Enter designation name')
                    ]); ?>

                </div>

                <div class="form-group mb-3">
                    <?php echo Form::label('branch_id', __('Branch'), ['class' => 'form-label']); ?>

                    <?php echo Form::select('branch_id', $branches, null, [
                        'class' => 'form-control select',
                        'required' => true,
                        'placeholder' => __('Select Branch')
                    ]); ?>

                </div>

                <div class="form-group mb-3">
                    <?php echo Form::label('department_id', __('Department'), ['class' => 'form-label']); ?>

                    <?php echo Form::select('department_id', $departments, null, [
                        'class' => 'form-control select',
                        'required' => true,
                        'placeholder' => __('Select Department')
                    ]); ?>

                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
        </div>
    </div>
<?php echo Form::close(); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\designation\edit.blade.php ENDPATH**/ ?>