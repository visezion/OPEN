<?php echo e(Form::model($bank_transfer_payment,array('route' => array('invoice.bankaccount.request.update', $bank_transfer_payment->id), 'method' => 'POST'))); ?>

    <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered ">
                <tr>
                    <th><?php echo e(__('Number')); ?></th>
                    <td><?php echo e($invoice_id); ?></td>
                </tr>
                <tr role="row">
                    <th><?php echo e(__('Order Id')); ?></th>
                    <td><?php echo e($bank_transfer_payment->order_id); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Status')); ?></th>
                    <td>
                        <span class="badge bg-warning p-2 px-3 text-white"><?php echo e(ucfirst($bank_transfer_payment->status)); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><?php echo e(__('Price')); ?></th>
                    <td><?php echo e(currency_format_with_sym($bank_transfer_payment->price)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Payment Type')); ?></th>
                    <td><?php echo e(('Bank Account')); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Payment Date')); ?></th>
                    <td><?php echo e(company_date_formate($bank_transfer_payment->created_at)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Bank Detail')); ?></th>
                    <td>
                        <span><b><?php echo e(__('Bank Name')); ?> : </b>  <?php echo e($bank_account->bank_name); ?></><br>
                        <span><b><?php echo e(__('Account Number')); ?> : </b>  <?php echo e($bank_account->account_number); ?></><br>
                        <span><b><?php echo e(__('Current Balance')); ?> : </b>  <?php echo e($bank_account->opening_balance); ?></><br>
                        <span><b><?php echo e(__('Account Holder Name')); ?> : </b>  <?php echo e($bank_account->holder_name); ?></><br>

                    </td>
                </tr>
                <tr>
                    <th><?php echo e(__('Attachment')); ?></th>
                    <td class="d-flex">
                        <?php if(!empty($bank_transfer_payment->attachment) && (check_file($bank_transfer_payment->attachment))): ?>
                            <div class="action-btn bg-primary me-2">
                                <a class="btn btn-sm align-items-center" href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>" download>
                                    <i class="ti ti-download text-white"></i>
                                </a>
                            </div>
                            <div class="action-btn bg-secondary">
                                <a class="btn btn-sm align-items-center" href="<?php echo e(get_file($bank_transfer_payment->attachment)); ?>" target="_blank"  >
                                    <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Preview')); ?>"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <?php echo e(__('Not Found')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php if($bank_transfer_payment->status == 'Pending'): ?>
        <div class="modal-footer">
            <input type="submit" value="<?php echo e(__('Approved')); ?>" class="btn btn-success" name="status">
            <input type="submit" value="<?php echo e(__('Reject')); ?>" class="btn btn-danger" name="status">
        </div>
    <?php endif; ?>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\payment\invoice_action.blade.php ENDPATH**/ ?>