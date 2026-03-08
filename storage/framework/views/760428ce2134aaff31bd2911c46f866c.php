
<div class="tab-pane fade " id="stripe-payment" role="tabpanel"
    aria-labelledby="stripe-payment">
    <form method="post" action="<?php echo e(route('memberplan.pay.with.stripe')); ?>"
        class="require-validation" id="payment-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="amount"><?php echo e(__('Amount')); ?></label>
                <div class="input-group">
                    <span class="input-group-prepend"><span
                            class="input-group-text"><?php echo e(isset($company_settings['defult_currancy']) ? $company_settings['defult_currancy'] : '$'); ?></span></span>
                    <input class="form-control" required="required"
                        min="0" name="amount" type="number"
                        value="<?php echo e(\Workdo\GymManagement\Entities\GymMember::getDue($assignmembershipplan->fee,$user->id)); ?>" min="0"
                        step="0.01" max="<?php echo e(\Workdo\GymManagement\Entities\GymMember::getDue($assignmembershipplan->fee,$user->id)); ?>"

                        id="amount">
                    <input type="hidden" value="<?php echo e($assignmembershipplan->id); ?>"
                        name="membershipplan_id">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="error" style="display: none;">
                    <div class='alert-danger alert'>
                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn  btn-secondary me-1"
                data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <button class="btn btn-primary"
                type="submit"><?php echo e(__('Make Payment')); ?></button>
        </div>
    </form>
</div>

<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\member_plan_payment.blade.php ENDPATH**/ ?>