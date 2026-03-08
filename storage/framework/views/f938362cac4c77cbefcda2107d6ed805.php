<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Manage Bill')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Bill')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script-page'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('.cp_link').on('click', function() {
        var value = $(this).attr('data-link');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(value).select();
        document.execCommand("copy");
        $temp.remove();
        toastrs('Success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="retainer-settings" class="row">
    <div class="col-md-3">
        <?php echo $__env->make('taskly::layouts.finance_tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-md-9">
        <div class="card retainer">
            <div class="card-header">
                <div class="row">
                    <div class="col-11">
                        <h5 class="">
                            <?php echo e(__('Bill')); ?>

                        </h5>
                    </div>
                    <?php if (app('laratrust')->hasPermission('bill create')) : ?>
                        <div class=" col-1 text-end">
                            <a href="<?php echo e(route('bills.create', ['cid' => 0,'type' => 'project', 'project_id' => $project->id ,'redirect_route' =>route('projects.bill', $project->id)])); ?>

                                    " class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                data-bs-original-title="<?php echo e(__('Create')); ?>">
                                <i class="ti ti-plus"></i>
                            </a>
                        </div>
                    <?php endif; // app('laratrust')->permission ?>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 pc-dt-simple" id="assets">
                        <thead>
                            <tr>
                                <th> <?php echo e(__('Bill')); ?></th>
                                <?php if(!\Auth::user()->type != 'vendor'): ?>
                                    <th> <?php echo e(__('Vendor')); ?></th>
                                <?php endif; ?>
                                <th> <?php echo e(__('Account Type')); ?></th>
                                <th> <?php echo e(__('Bill Date')); ?></th>
                                <th> <?php echo e(__('Due Date')); ?></th>
                                <th><?php echo e(__('Due Amount')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <?php if(Laratrust::hasPermission('bill edit') ||
                                        Laratrust::hasPermission('bill delete') ||
                                        Laratrust::hasPermission('bill show') ||
                                        Laratrust::hasPermission('bill duplicate')): ?>
                                    <th width="10%"> <?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-style">
                                    <td class="Id">
                                        <?php if (app('laratrust')->hasPermission('bill show')) : ?>
                                            <a href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>"
                                                class="btn btn-outline-primary"><?php echo e(Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?></a>
                                        <?php else: ?>
                                            <a
                                                class="btn btn-outline-primary"><?php echo e(Workdo\Account\Entities\Bill::billNumberFormat($bill->bill_id)); ?></a>
                                <?php endif; ?>
                                </td>

                                <?php if(!\Auth::user()->type != 'vendor'): ?>
                                    <td> <?php echo e(!empty($bill->vendor_name) ? $bill->vendor_name : ''); ?></td>
                                <?php endif; ?>
                                <td><?php echo e($bill->account_type); ?></td>
                                <td><?php echo e(company_date_formate($bill->bill_date)); ?></td>
                                <td>
                                    <?php if($bill->due_date < date('Y-m-d')): ?>
                                        <p class="text-danger">
                                            <?php echo e(company_date_formate($bill->due_date)); ?></p>
                                    <?php else: ?>
                                        <?php echo e(company_date_formate($bill->due_date)); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(currency_format_with_sym($bill->getDue())); ?></td>
                                <td>
                                    <?php if($bill->status == 0): ?>
                                        <span
                                            class="badge bg-info p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                    <?php elseif($bill->status == 1): ?>
                                        <span
                                            class="badge bg-primary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                    <?php elseif($bill->status == 2): ?>
                                        <span
                                            class="badge bg-secondary p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                    <?php elseif($bill->status == 3): ?>
                                        <span
                                            class="badge bg-warning p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                    <?php elseif($bill->status == 4): ?>
                                        <span
                                            class="badge bg-success p-2 px-3 bill_status"><?php echo e(__(Workdo\Account\Entities\Bill::$statues[$bill->status])); ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if(Laratrust::hasPermission('bill edit') ||
                                        Laratrust::hasPermission('bill delete') ||
                                        Laratrust::hasPermission('bill show') ||
                                        Laratrust::hasPermission('bill duplicate')): ?>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn  me-2">
                                                <a href="#" class="btn btn-sm bg-primary  align-items-center cp_link"
                                                    data-link="<?php echo e(route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id))); ?>"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>"
                                                    data-original-title="<?php echo e(__('Click to copy Bill link')); ?>">
                                                    <i class="ti ti-file text-white"></i>
                                                </a>
                                            </div>
                                            <?php if (app('laratrust')->hasPermission('bill duplicate')) : ?>
                                                <div class="action-btn  me-2">
                                                    <?php echo Form::open([
                                                        'method' => 'get',
                                                        'route' => ['bill.duplicate', $bill->id],
                                                        'id' => 'duplicate-form-' . $bill->id,
                                                    ]); ?>

                                                    <a class="mx-3 btn btn-sm bg-secondary align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="<?php echo e(__('Duplicate')); ?>" aria-label="Delete"
                                                        data-text="<?php echo e(__('You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back')); ?>"
                                                        data-confirm-yes="duplicate-form-<?php echo e($bill->id); ?>">
                                                        <i class="ti ti-copy text-white text-white"></i>
                                                    </a>
                                                    <?php echo e(Form::close()); ?>

                                                </div>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if (app('laratrust')->hasPermission('bill show')) : ?>
                                                <div class="action-btn  me-2">
                                                    <a href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>"
                                                        class="mx-3 btn bg-warning btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="<?php echo e(__('Show')); ?>" data-original-title="<?php echo e(__('Detail')); ?>">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; // app('laratrust')->permission ?>
                                            <?php if(module_is_active('ProductService') && $bill->bill_module == 'taskly'
                                                    ? module_is_active('Taskly')
                                                    : module_is_active('Account')): ?>
                                                <?php if (app('laratrust')->hasPermission('bill edit')) : ?>
                                                    <div class="action-btn  me-2">
                                                        <a href="<?php echo e(route('bill.edit', \Crypt::encrypt($bill->id))); ?>"
                                                            class="mx-3 btn bg-info btn-sm align-items-center" data-bs-toggle="tooltip"
                                                            title="Edit" data-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                            <?php endif; ?>
                                            <?php if (app('laratrust')->hasPermission('bill delete')) : ?>
                                                <div class="action-btn">
                                                    <?php echo e(Form::open(['route' => ['bill.destroy', $bill->id], 'class' => 'm-0'])); ?>

                                                    <?php echo method_field('DELETE'); ?>
                                                    <a class="mx-3 btn bg-danger btn-sm  align-items-center bs-pass-para show_confirm"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                        data-confirm-yes="delete-form-<?php echo e($bill->id); ?>"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    <?php echo e(Form::close()); ?>

                                                </div>
                                            <?php endif; // app('laratrust')->permission ?>
                                        </span>
                                    </td>
                                <?php endif; ?>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\project_bill.blade.php ENDPATH**/ ?>