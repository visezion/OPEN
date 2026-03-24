<div class="card">
    <div class="card-header">
        <h5><?php echo e(__('Credit Note Summary')); ?></h5>
    </div>
    <div class="card-body table-border-style table-border-style">
        <div class="table-responsive">
            <table class="table mb-0 pc-dt-simple" id="credir-note">
                <thead>
                    <tr>
                        <th class="text-dark"><?php echo e(__('Credit Note')); ?></th>
                        <th class="text-dark"><?php echo e(__('Date')); ?></th>
                        <th class="text-dark" class=""><?php echo e(__('Amount')); ?></th>
                        <th class="text-dark" class=""><?php echo e(__('Description')); ?></th>
                        <?php if(Laratrust::hasPermission('creditnote edit') || Laratrust::hasPermission('creditnote delete')): ?>
                            <th class="text-dark"><?php echo e(__('Action')); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <?php $__empty_1 = true; $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><a href="#" class="btn btn-outline-primary"><?php echo e(!empty($creditNote->creditNote) ? \Workdo\Account\Entities\CustomerCreditNotes::creditNumberFormat($creditNote->creditNote->credit_id) : '-'); ?></a></td>
                        <td><?php echo e(company_date_formate($creditNote->date)); ?></td>
                        <td class=""><?php echo e(currency_format_with_sym($creditNote->amount)); ?></td>
                        <td class=""><?php echo e($creditNote->description); ?></td>
                        <?php if(Laratrust::hasPermission('creditnote edit') || Laratrust::hasPermission('creditnote delete')): ?>
                            <td>
                                <?php if (app('laratrust')->hasPermission('creditnote edit')) : ?>
                                    <div class="action-btn  me-2">
                                        <a data-url="<?php echo e(route('invoice.edit.credit.note', [$creditNote->invoice, $creditNote->id])); ?>"
                                            data-ajax-popup="true" title="<?php echo e(__('Edit')); ?>"
                                            data-original-title="<?php echo e(__('Credit Note')); ?>"
                                            class="mx-3 btn bg-info btn-sm align-items-center"
                                            data-title="<?php echo e(__('Edit Credit Note')); ?>" data-bs-toggle="tooltip">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>
                                <?php endif; // app('laratrust')->permission ?>
                                <?php if (app('laratrust')->hasPermission('creditnote delete')) : ?>
                                    <div class="action-btn">
                                        <?php echo e(Form::open(['route' => ['invoice.delete.credit.note', $creditNote->invoice, $creditNote->id], 'class' => 'm-0'])); ?>

                                        <?php echo method_field('DELETE'); ?>
                                        <a class="mx-3 btn btn-sm  bg-danger align-items-center bs-pass-para show_confirm"
                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                            aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                            data-confirm-yes="delete-form-<?php echo e($creditNote->id); ?>"><i
                                                class="ti ti-trash text-white text-white"></i></a>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                <?php endif; // app('laratrust')->permission ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\invoice\invoice_section.blade.php ENDPATH**/ ?>