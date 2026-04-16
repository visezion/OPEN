<?php echo e(Form::model($bank_transfer_payment, ['route' => ['bank-transfer-request.update', $bank_transfer_payment->id], 'method' => 'PUT'])); ?>

    <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered ">
                <tr role="row">
                    <th><?php echo e(__('Order Id')); ?></th>
                    <td><?php echo e($bank_transfer_payment->order_id); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('status')); ?></th>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bank_transfer_payment->status == 'Approved'): ?>
                            <span class="badge bg-success p-2 px-3 text-white"><?php echo e(ucfirst($bank_transfer_payment->status)); ?></span>
                        <?php elseif($bank_transfer_payment->status == 'Pending'): ?>
                            <span class="badge bg-warning p-2 px-3 text-white"><?php echo e(ucfirst($bank_transfer_payment->status)); ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger p-2 px-3 text-white"><?php echo e(ucfirst($bank_transfer_payment->status)); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo e(__('Appplied On')); ?></th>
                    <td><?php echo e(company_datetime_formate($bank_transfer_payment->created_at)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Name')); ?></th>
                    <td><?php echo e(!empty($bank_transfer_payment->User) ? $bank_transfer_payment->User->name : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Price')); ?></th>
                    <td><?php echo e(super_currency_format_with_sym($bank_transfer_payment->price)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Request')); ?></th>
                    <?php
                        $requests = json_decode($bank_transfer_payment->request);
                        $modules = explode(',',$requests->user_module_input);

                    ?>

                    <td>
                            <p><span class="text-primary"><?php echo e(__('Workspace: ')); ?></span><?php echo e($requests->workspace_counter_input); ?></p>
                            <p><span class="text-primary"><?php echo e(__('Users: ')); ?></span><?php echo e($requests->user_counter_input); ?></p>
                            <p><span class="text-primary"><?php echo e(__('Time Period: ')); ?></span><?php echo e($requests->time_period); ?></p>
                            <div class="">
                                <span class="text-primary"><?php echo e(__('Add-on: ')); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module): ?>
                                        <a href="<?php echo e(route('software.details',$module)); ?>" target="_new" class="btn btn-sm btn-warning me-2"><?php echo e($module); ?></a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo e(__('Attachment')); ?></th>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($bank_transfer_payment->attachment) && (check_file($bank_transfer_payment->attachment))): ?>
                            <div class="action-btn me-2">
                                <a class="mx-3 btn btn-sm align-items-center bg-primary" href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>" download>
                                    <i class="ti ti-download text-white"></i>
                                </a>
                            </div>
                            <div class="action-btn">
                                <a class="mx-3 btn btn-sm align-items-center bg-secondary" href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>" target="_blank"  >
                                    <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Preview')); ?>"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <?php echo e(__('Not Found')); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bank_transfer_payment->status == 'Pending'): ?>
        <div class="modal-footer">
            <a href=""></a>
            <input type="submit" value="<?php echo e('Reject'); ?>" class="btn btn-danger" name="status">
            <input type="submit" value="<?php echo e('Approved'); ?>" class="btn btn-success" name="status">
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\bank_transfer\action.blade.php ENDPATH**/ ?>