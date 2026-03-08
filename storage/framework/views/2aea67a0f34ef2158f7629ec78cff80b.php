<!--Bank Accounts Settings-->

<div id="bank-accounts-sidenav" class="card">
    <?php echo e(Form::open(['route' => ['bankaccount.setting.store'], 'id' => 'payment-form'])); ?>

    <div class="card-header p-3">
        <div class="d-flex align-items-center">
            <div class="col-sm-10 col-9">
                <h5 class=""><?php echo e(__('Bank Accounts')); ?></h5>
                <small><?php echo e(__('Edit Bank Accounts settings')); ?></small>
            </div>
            <div class="col-sm-2 col-3 text-end">
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="bank_account_payment_is_on" class="form-check-input input-primary"
                        id="bank_account_payment_is_on"
                        <?php echo e(isset($settings['bank_account_payment_is_on']) && $settings['bank_account_payment_is_on'] == 'on' ? ' checked ' : ''); ?>>
                    <label class="form-check-label" for="bank_account_payment_is_on"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-3" style="max-height: 270px; overflow:auto">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Bank')); ?></th>
                        <th><?php echo e(__('Account number')); ?></th>
                        <th><?php echo e(__('Current Balance')); ?></th>
                        <th><?php echo e(__('Bank Address')); ?></th>
                        <th><?php echo e(__('Contact Number')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>
                    </tr>
                </thead>
                <tbody class="list"   <?php echo e(isset($settings['bank_account_payment_is_on']) && $settings['bank_account_payment_is_on'] == 'on' ? '' : ' disabled'); ?> id="bank_accounts_details">
                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($account->holder_name); ?></td>
                            <td><?php echo e($account->bank_name); ?></td>
                            <td><?php echo e($account->account_number); ?></td>
                            <td><?php echo e(currency_format_with_sym($account->opening_balance)); ?></td>
                            <td><?php echo e($account->bank_address); ?></td>
                            <td><?php echo e($account->contact_number); ?></td>

                            <td>
                                <div class="form-check form-switch custom-switch-v1 float-end">
                                    <input type="hidden" name="bank_account[<?php echo e($account->id); ?>]" value="off">
                                    <?php
                                        $bankAccountArray = isset($settings['bank_account']) ? explode(',', $settings['bank_account']) : [];

                                    ?>
                                    <input type="checkbox" class="form-check-input input-primary" name="bank_account[<?php echo e($account->id); ?>]"
                                        data-bs-placement="top" data-id="<?php echo e($account->id); ?>" data-title="<?php echo e(__('Enable/Disable')); ?>" id="bank_account_<?php echo e($account->id); ?>"
                                        data-bs-toggle="tooltip"
                                        <?php echo e(is_array($bankAccountArray) && in_array($account->id, $bankAccountArray) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="bank_account_<?php echo e($account->id); ?>"></label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-end p-3">
        <input class="btn btn-print-invoice btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\company\settings\bank_account.blade.php ENDPATH**/ ?>