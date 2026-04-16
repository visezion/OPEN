<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 table-responsive">
            <table class="table modal-table">
                <tbody>
                    <tr>
                        <th><?php echo e(__('Name')); ?></th>
                        <td><?php echo e(!empty($bankAccount->bank_name) ? $bankAccount->bank_name : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Bank')); ?></th>
                        <td><?php echo e(!empty($bankAccount->holder_name) ? $bankAccount->holder_name : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Account Number')); ?></th>
                        <td><?php echo e(!empty($bankAccount->account_number) ? $bankAccount->account_number : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Contact Number')); ?></th>
                        <td><?php echo e(!empty($bankAccount->contact_number) ? $bankAccount->contact_number : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Bank Branch')); ?></th>
                        <td><?php echo e(!empty($bankAccount->bank_branch) ? $bankAccount->bank_branch : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('SWIFT')); ?></th>
                        <td><?php echo e(!empty($bankAccount->swift) ? $bankAccount->swift : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Payment Gateway')); ?></th>
                        <td><?php echo e(!empty($bankAccount->payment_name) ? $bankAccount->payment_name : '--'); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Bank Address')); ?></th>
                        <td><?php echo e(!empty($bankAccount->bank_address) ? $bankAccount->bank_address : '--'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bankAccount\view.blade.php ENDPATH**/ ?>