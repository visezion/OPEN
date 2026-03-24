<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Customer Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e(__('Customer Detail')); ?>,<?php echo e($customer['name']); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
   .cus-card {
   min-height: 204px;
   }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
   $(document).on('click', '#billing_data', function() {
       $("[name='shipping_name']").val($("[name='billing_name']").val());
       $("[name='shipping_country']").val($("[name='billing_country']").val());
       $("[name='shipping_state']").val($("[name='billing_state']").val());
       $("[name='shipping_city']").val($("[name='billing_city']").val());
       $("[name='shipping_phone']").val($("[name='billing_phone']").val());
       $("[name='shipping_zip']").val($("[name='billing_zip']").val());
       $("[name='shipping_address']").val($("[name='billing_address']").val());
   })
</script>
<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script>
   var filename = $('#filename').val();

   function saveAsPDF() {
       var element = document.getElementById('printableArea');
       var opt = {
           margin: 0.3,
           filename: filename,
           image: {
               type: 'jpeg',
               quality: 1
           },
           html2canvas: {
               scale: 4,
               dpi: 72,
               letterRendering: true
           },
           jsPDF: {
               unit: 'in',
               format: 'A4'
           }
       };
       html2pdf().set(opt).from(element).save();
   }
</script>
<script>
   $(".apply_btn").click(function() {
       var from_date = $('.from_date').val();
       var until_date = $('.until_date').val();
       var id = "<?php echo e($customer['id']); ?>";
       var type = "statement_tab";
       $.ajax({
           url: '<?php echo e(route('customer.statement', $customer['id'])); ?>',
           type: 'POST',
           data: {
               "id": id,
               "from_date": from_date,
               "until_date": until_date,
               "type": type,
               "_token": "<?php echo e(csrf_token()); ?>",
           },
           success: function(data) {
               $("#statement-history .list").empty();

               // Initialize the total amount
               var totalAmount = 0;

               // Iterate over the data array and build the rows
               data.data.forEach(function(item) {


                   var rowHtml = '<tr>' +
                       '<td>' + item.date + '</td>' +
                       '<td>' + item.invoiceno + '</td>' +
                       '<td>' + item.payment_type + '</td>' +
                       '<td>' + data.currencySymbol + item.amount + '</td>' +
                       '</tr>';
                   $("#statement-history .list").append(rowHtml);

                   // Update the total amount
                   totalAmount += parseFloat(item.amount);
               });

               // Display the total amount in the total row
               $("#total-amount").html('<strong>' + data.currencySymbol + totalAmount.toFixed(2) +
                   '</strong>');
           }
       });

   });
</script>
<?php $__env->stopPush(); ?>
<?php
$company_settings = getCompanyAllSetting();
$company_settings['invoice_shipping_display'] = isset($company_settings['invoice_shipping_display']) ? $company_settings['invoice_shipping_display'] : 'off';
$company_settings['proposal_shipping_display'] = isset($company_settings['proposal_shipping_display']) ? $company_settings['proposal_shipping_display'] : 'off';
?>
<?php $__env->startSection('page-action'); ?>
<div class="d-flex">
   <?php
   $user_id = !empty($customer->user_id) ? $customer->user_id : null;
   ?>
   <?php if (app('laratrust')->hasPermission('invoice create')) : ?>
   <a href="<?php echo e(route('invoice.create', $customer->id)); ?>" class="btn btn-sm btn-primary me-2">
   <?php echo e(__('Create Invoice')); ?>

   </a>
   <?php endif; // app('laratrust')->permission ?>
   <?php if (app('laratrust')->hasPermission('customer create')) : ?>
   <?php if(!empty($user_id)): ?>
   <a href="<?php echo e(route('proposal.create', $customer->id)); ?>" class="btn btn-sm btn-primary me-2">
   <?php echo e(__('Create Proposal')); ?>

   </a>
   <?php endif; ?>
   <?php endif; // app('laratrust')->permission ?>
   <?php if(module_is_active('Retainer')): ?>
   <a href="<?php echo e(route('retainer.create', $customer->id)); ?>" class="btn btn-sm btn-primary me-2">
   <?php echo e(__('Create Retainer')); ?>

   </a>
   <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
   <div class="page-block">
      <div class="row align-items-center">
         <div class="col-md-4">
         </div>
         <div class="col-md-8 mt-4">
            <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="customer-details-tab" data-bs-toggle="pill"
                     data-bs-target="#customer-details" type="button"><?php echo e(__('Details')); ?></button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="customer-proposal-tab" data-bs-toggle="pill"
                     data-bs-target="#customer-proposal" type="button"><?php echo e(__('Proposals')); ?></button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="customer-invoice-tab" data-bs-toggle="pill"
                     data-bs-target="#customer-invoice" type="button"><?php echo e(__('Invoices')); ?></button>
               </li>
               <?php echo $__env->yieldPushContent('customer_retainer_tab'); ?>
               <li class="nav-item" role="presentation">
                  <button class="nav-link " id="customer-revenue-tab" data-bs-toggle="pill"
                     data-bs-target="#customer-revenue" type="button"><?php echo e(__('Revenue')); ?></button>
               </li>
               <?php echo $__env->yieldPushContent('customer_project_tab'); ?>
               <li class="nav-item" role="presentation">
                  <button class="nav-link " id="statement-tab" data-bs-toggle="pill" data-bs-target="#statement"
                     type="button"><?php echo e(__('Statement')); ?></button>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-sm-12 ">
      <div class="row">
         <div class="col-lg-12">
            <div class="tab-content" id="pills-tabContent">
               <div class="tab-pane fade active show" id="customer-details" role="tabpanel"
                  aria-labelledby="pills-user-tab-1">
                  <div class="row">
                     <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card customer-detail-box">
                           <div class="card-body cus-card">
                              <h5 class="card-title"><?php echo e(__('Customer Info')); ?></h5>
                              <p class="card-text mb-0"><?php echo e($customer['name']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['email']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['contact']); ?></p>
                              <?php if(!empty($customFields) && count($customer->customField) > 0): ?>
                              <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <p class="card-text mb-0">
                                 <strong><?php echo e($field->name); ?> :
                                 </strong><?php echo e(!empty($customer->customField[$field->id]) ? $customer->customField[$field->id] : '-'); ?>

                              </p>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>
                              <?php echo $__env->yieldPushContent('show_electronic_address'); ?>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card customer-detail-box">
                           <div class="card-body cus-card">
                              <h5 class="card-title"><?php echo e(__('Billing Info')); ?></h5>
                              <p class="card-text mb-0"><?php echo e($customer['billing_name']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['billing_phone']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['billing_address']); ?></p>
                              <p class="card-text mb-0">
                                 <?php echo e($customer['billing_city'] . ', ' . $customer['billing_state'] . ', ' . $customer['billing_country']); ?>

                              </p>
                              <p class="card-text mb-0"><?php echo e($customer['billing_zip']); ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card customer-detail-box">
                           <div class="card-body cus-card">
                              <h5 class="card-title"><?php echo e(__('Shipping Info')); ?></h5>
                              <?php if($company_settings['invoice_shipping_display'] == 'on' || $company_settings['proposal_shipping_display'] == 'on'): ?>
                              <p class="card-text mb-0"><?php echo e($customer['shipping_name']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['shipping_phone']); ?></p>
                              <p class="card-text mb-0"><?php echo e($customer['shipping_address']); ?></p>
                              <p class="card-text mb-0">
                                 <?php echo e($customer['shipping_city'] . ', ' . $customer['shipping_state'] . ', ' . $customer['shipping_country']); ?>

                              </p>
                              <p class="card-text mb-0"><?php echo e($customer['shipping_zip']); ?></p>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card pb-0">
                           <div class="card-body">
                              <h5 class="card-title"><?php echo e(__('Company Info')); ?></h5>
                              <div class="row">
                                 <?php
                                 $totalInvoiceSum = $customer->customerTotalInvoiceSum($customer['id']);
                                 $totalInvoice = $customer->customerTotalInvoice($customer['id']);
                                 $averageSale = $totalInvoiceSum != 0 ? $totalInvoiceSum / $totalInvoice : 0;
                                 ?>
                                 <div class="col-md-3 col-sm-6">
                                    <div class="p-4">
                                       <h6 class="card-text mb-0"><?php echo e(__('Customer Id')); ?></h6>
                                       <p class="report-text mb-3">
                                          <?php echo e(Workdo\Account\Entities\Customer::customerNumberFormat($customer['customer_id'])); ?>

                                       </p>
                                       <h6 class="card-text mb-0"><?php echo e(__('Total Sum of Invoices')); ?></h6>
                                       <p class="report-text mb-0">
                                          <?php echo e(currency_format_with_sym($totalInvoiceSum)); ?>

                                       </p>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6">
                                    <div class="p-4">
                                       <h6 class="card-text mb-0"><?php echo e(__('Date of Creation')); ?></h6>
                                       <p class="report-text mb-3">
                                          <?php echo e(company_date_formate($customer['created_at'])); ?>

                                       </p>
                                       <h6 class="card-text mb-0"><?php echo e(__('Quantity of Invoice')); ?></h6>
                                       <p class="report-text mb-0"><?php echo e($totalInvoice); ?></p>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6">
                                    <div class="p-4">
                                       <h6 class="card-text mb-0"><?php echo e(__('Balance')); ?></h6>
                                       <p class="report-text mb-3">
                                          <?php echo e(currency_format_with_sym($customer['balance'])); ?>

                                       </p>
                                       <h6 class="card-text mb-0"><?php echo e(__('Average Sales')); ?></h6>
                                       <p class="report-text mb-0">
                                          <?php echo e(currency_format_with_sym($averageSale)); ?>

                                       </p>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-6">
                                    <div class="p-4">
                                       <h6 class="card-text mb-0"><?php echo e(__('Overdue')); ?></h6>
                                       <p class="report-text mb-3">
                                          <?php echo e(currency_format_with_sym($customer->customerOverdue($customer['id']))); ?>

                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="customer-proposal" role="tabpanel"
                  aria-labelledby="pills-user-tab-2">
                  <div class="row">
                     <div class="col-12">
                        <div class="card">
                           <div class="card-body table-border-style table-border-style">
                              <h5 class="d-inline-block mb-5"><?php echo e(__('Proposal')); ?></h5>
                              <div class="table-responsive">
                                 <table class="table mb-0 pc-dt-simple" id="vendor_project">
                                    <thead>
                                       <tr>
                                          <th><?php echo e(__('Proposal')); ?></th>
                                          <th><?php echo e(__('Issue Date')); ?></th>
                                          <th><?php echo e(__('Amount')); ?></th>
                                          <th><?php echo e(__('Status')); ?></th>
                                          <?php if(Laratrust::hasPermission('proposal edit') ||
                                          Laratrust::hasPermission('proposal delete') ||
                                          Laratrust::hasPermission('proposal show')): ?>
                                          <th width="10%"> <?php echo e(__('Action')); ?></th>
                                          <?php endif; ?>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $customer->customerProposal($customer->user_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                       <tr>
                                          <td class="Id">
                                             <?php if (app('laratrust')->hasPermission('proposal show')) : ?>
                                             <a href="<?php echo e(route('proposal.show', \Crypt::encrypt($proposal->id))); ?>"
                                                class="btn btn-outline-primary"><?php echo e(\App\Models\Proposal::proposalNumberFormat($proposal->proposal_id)); ?>

                                             </a>
                                             <?php else: ?>
                                             <a class="btn btn-outline-primary"><?php echo e(\App\Models\Proposal::proposalNumberFormat($proposal->proposal_id)); ?>

                                             </a>
                                             <?php endif; // app('laratrust')->permission ?>
                                          </td>
                                          <td><?php echo e(company_date_formate($proposal->issue_date)); ?></td>
                                          <td><?php echo e(currency_format_with_sym($proposal->getTotal())); ?>

                                          </td>
                                          <td>
                                             <?php if($proposal->status == 0): ?>
                                             <span
                                                class="badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                             <?php elseif($proposal->status == 1): ?>
                                             <span
                                                class="badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                             <?php elseif($proposal->status == 2): ?>
                                             <span
                                                class="badge bg-danger p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                             <?php elseif($proposal->status == 3): ?>
                                             <span
                                                class="badge bg-info p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                             <?php elseif($proposal->status == 4): ?>
                                             <span
                                                class="badge bg-success p-2 px-3"><?php echo e(__(\App\Models\Proposal::$statues[$proposal->status])); ?></span>
                                             <?php endif; ?>
                                          </td>
                                          <?php if(Laratrust::hasPermission('proposal edit') ||
                                          Laratrust::hasPermission('proposal delete') ||
                                          Laratrust::hasPermission('proposal show')): ?>
                                          <td class="Action">
                                             <span>
                                                <?php if($proposal->is_convert == 0): ?>
                                                <?php if (app('laratrust')->hasPermission('proposal convert invoice')) : ?>
                                                <div class="action-btn  me-2">
                                                   <?php echo Form::open([
                                                   'method' => 'get',
                                                   'route' => ['proposal.convert', $proposal->id],
                                                   'id' => 'proposal-form-' . $proposal->id,
                                                   ]); ?>

                                                   <a class="mx-3 btn bg-success btn-sm  align-items-center bs-pass-para show_confirm"
                                                      data-bs-toggle="tooltip"
                                                      title=""
                                                      data-bs-original-title="<?php echo e(__('Convert to Invoice')); ?>"
                                                      aria-label="Delete"
                                                      data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                      data-confirm-yes="proposal-form-<?php echo e($proposal->id); ?>">
                                                   <i
                                                      class="ti ti-exchange text-white"></i>
                                                   </a>
                                                   <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php else: ?>
                                                <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($proposal->converted_invoice_id))); ?>"
                                                      class="mx-3 btn bg-success btn-sm  align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('Already convert to Invoice')); ?>">
                                                   <i
                                                      class="ti ti-eye text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php endif; ?>
                                                <?php if (app('laratrust')->hasPermission('duplicate proposal')) : ?>
                                                <div class="action-btn  me-2">
                                                   <?php echo Form::open([
                                                   'method' => 'get',
                                                   'route' => ['proposal.duplicate', $proposal->id],
                                                   'id' => 'duplicate-form-' . $proposal->id,
                                                   ]); ?>

                                                   <a class="mx-3 btn bg-secondary btn-sm  align-items-center bs-pass-para show_confirm"
                                                      data-bs-toggle="tooltip"
                                                      title=""
                                                      data-bs-original-title="<?php echo e(__('Duplicate')); ?>"
                                                      aria-label="Delete"
                                                      data-text="<?php echo e(__('You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back')); ?>"
                                                      data-confirm-yes="duplicate-form-<?php echo e($proposal->id); ?>">
                                                   <i
                                                      class="ti ti-copy text-white text-white"></i>
                                                   </a>
                                                   <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('proposal show')) : ?>
                                                <?php if(\Auth::user()->type == 'client'): ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('customer.proposal.show', $proposal->id)); ?>"
                                                      class="mx-3 btn bg-warning btn-sm align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('Show')); ?>"
                                                      data-original-title="<?php echo e(__('Detail')); ?>">
                                                   <i
                                                      class="ti ti-eye text-white text-white"></i>
                                                   </a>
                                                </div>
                                                <?php else: ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('proposal.show', \Crypt::encrypt($proposal->id))); ?>"
                                                      class="mx-3 btn bg-warning btn-sm  align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('Show')); ?>"
                                                      data-original-title="<?php echo e(__('Detail')); ?>">
                                                   <i
                                                      class="ti ti-eye text-white text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; ?>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('proposal edit')) : ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('proposal.edit', \Crypt::encrypt($proposal->id))); ?>"
                                                      class="mx-3 btn bg-info btn-sm  align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                   <i class="ti ti-pencil text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('proposal delete')) : ?>
                                                <div class="action-btn">
                                                   <?php echo e(Form::open(['route' => ['proposal.destroy', $proposal->id], 'class' => 'm-0'])); ?>

                                                   <?php echo method_field('DELETE'); ?>
                                                   <a class="mx-3 btn  bg-danger btn-sm  align-items-center bs-pass-para show_confirm"
                                                      data-bs-toggle="tooltip"
                                                      title=""
                                                      data-bs-original-title="Delete"
                                                      aria-label="Delete"
                                                      data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                      data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                      data-confirm-yes="delete-form-<?php echo e($proposal->id); ?>"><i
                                                      class="ti ti-trash text-white text-white"></i></a>
                                                   <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                             </span>
                                          </td>
                                          <?php endif; ?>
                                       </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                       <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="customer-invoice" role="tabpanel"
                  aria-labelledby="pills-user-tab-3">
                  <div class="row">
                     <div class="col-12">
                        <div class="card">
                           <div class="card-body table-border-style">
                              <div class="table-responsive">
                                 <table class="table mb-0 pc-dt-simple" id="invoice_project">
                                    <thead>
                                       <tr>
                                          <th><?php echo e(__('Invoice')); ?></th>
                                          <th><?php echo e(__('Issue Date')); ?></th>
                                          <th><?php echo e(__('Due Date')); ?></th>
                                          <th><?php echo e(__('Due Amount')); ?></th>
                                          <th><?php echo e(__('Status')); ?></th>
                                          <?php if(Laratrust::hasPermission('invoice edit') ||
                                          Laratrust::hasPermission('invoice delete') ||
                                          Laratrust::hasPermission('invoice show')): ?>
                                          <th width="10%"> <?php echo e(__('Action')); ?></th>
                                          <?php endif; ?>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $customer->customerInvoice($customer->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                       <tr>
                                          <td class="Id">
                                             <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                                             <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($invoice->id))); ?>"
                                                class="btn btn-outline-primary"><?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?>

                                             </a>
                                             <?php else: ?>
                                             <a class="btn btn-outline-primary"><?php echo e(\App\Models\Invoice::invoiceNumberFormat($invoice->invoice_id)); ?>

                                             </a>
                                             <?php endif; // app('laratrust')->permission ?>
                                          </td>
                                          <td><?php echo e(company_date_formate($invoice->issue_date)); ?></td>
                                          <td>
                                             <?php if($invoice->due_date < date('Y-m-d')): ?>
                                             <p class="text-danger">
                                                <?php echo e(company_date_formate($invoice->due_date)); ?>

                                             </p>
                                             <?php else: ?>
                                             <?php echo e(company_date_formate($invoice->due_date)); ?>

                                             <?php endif; ?>
                                          </td>
                                          <td><?php echo e(currency_format_with_sym($invoice->getDue())); ?>

                                          </td>
                                          <td>
                                                <?php if($invoice->status == 0): ?>
                                                <span
                                                    class="badge bg-info p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 1): ?>
                                                <span
                                                    class="badge bg-primary p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 2): ?>
                                                <span
                                                    class="badge bg-secondary p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 3): ?>
                                                <span
                                                    class="badge bg-warning p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php elseif($invoice->status == 4): ?>
                                                <span
                                                    class="badge bg-success p-2 px-3"><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></span>
                                                <?php endif; ?>
                                          </td>
                                          <?php if(Laratrust::hasPermission('invoice edit') ||
                                          Laratrust::hasPermission('invoice delete') ||
                                          Laratrust::hasPermission('invoice show')): ?>
                                          <td class="Action">
                                             <span>
                                                <?php if (app('laratrust')->hasPermission('duplicate invoice')) : ?>
                                                <div class="action-btn  me-2">
                                                   <?php echo Form::open([
                                                   'method' => 'get',
                                                   'route' => ['invoice.duplicate', $invoice->id],
                                                   'id' => 'invoice-duplicate-form-' . $invoice->id,
                                                   ]); ?>

                                                   <a class="mx-3 btn bg-secondary btn-sm align-items-center bs-pass-para"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('Duplicate Invoice')); ?>"
                                                      data-original-title="<?php echo e(__('Duplicate')); ?>"
                                                      data-confirm="<?php echo e(__('You want to confirm this action. Press Yes to continue or Cancel to go back')); ?>"
                                                      data-confirm-yes="document.getElementById('invoice-duplicate-form-<?php echo e($invoice->id); ?>').submit();">
                                                   <i
                                                      class="ti ti-copy text-white text-white"></i>
                                                   </a>
                                                   <?php echo Form::close(); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                                                <?php if(\Auth::user()->type == 'client'): ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('customer.invoice.show', \Crypt::encrypt($invoice->id))); ?>"
                                                      class="mx-3 btn bg-warning btn-sm align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('Show')); ?>"
                                                      data-original-title="<?php echo e(__('Detail')); ?>">
                                                   <i
                                                      class="ti ti-eye text-white text-white"></i>
                                                   </a>
                                                </div>
                                                <?php else: ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($invoice->id))); ?>"
                                                      class="mx-3 btn bg-warning btn-sm align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      title="<?php echo e(__('View')); ?>">
                                                   <i
                                                      class="ti ti-eye text-white text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; ?>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('invoice edit')) : ?>
                                                <div class="action-btn  me-2">
                                                   <a href="<?php echo e(route('invoice.edit', \Crypt::encrypt($invoice->id))); ?>"
                                                      class="mx-3 btn bg-info btn-sm  align-items-center"
                                                      data-bs-toggle="tooltip"
                                                      data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                   <i class="ti ti-pencil text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('invoice delete')) : ?>
                                                <div class="action-btn">
                                                   <?php echo e(Form::open(['route' => ['invoice.destroy', $invoice->id], 'class' => 'm-0'])); ?>

                                                   <?php echo method_field('DELETE'); ?>
                                                   <a class="mx-3 btn bg-danger btn-sm  align-items-center bs-pass-para show_confirm"
                                                      data-bs-toggle="tooltip"
                                                      title=""
                                                      data-bs-original-title="Delete"
                                                      aria-label="Delete"
                                                      data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                      data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                      data-confirm-yes="delete-form-<?php echo e($invoice->id); ?>">
                                                   <i
                                                      class="ti ti-trash text-white text-white"></i>
                                                   </a>
                                                   <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                             </span>
                                          </td>
                                          <?php endif; ?>
                                       </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                       <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php echo $__env->yieldPushContent('customer_retainer_div'); ?>
               <div class="tab-pane fade" id="customer-revenue" role="tabpanel"
                  aria-labelledby="pills-user-tab-4">
                  <div class="row">
                     <div class="col-12">
                        <div class="card">
                           <div class="card-body table-border-style">
                              <div class="table-responsive">
                                 <table class="table mb-0 pc-dt-simple" id="revenue_customer">
                                    <thead>
                                       <tr>
                                          <th><?php echo e(__('Date')); ?></th>
                                          <th><?php echo e(__('Amount')); ?></th>
                                          <th><?php echo e(__('Account')); ?></th>
                                          <th><?php echo e(__('Category')); ?></th>
                                          <th><?php echo e(__('Reference')); ?></th>
                                          <th><?php echo e(__('Description')); ?></th>
                                          <th><?php echo e(__('Payment Receipt')); ?></th>
                                          <?php if(Laratrust::hasPermission('revenue edit') || Laratrust::hasPermission('revenue delete')): ?>
                                          <th width="10%"> <?php echo e(__('Action')); ?></th>
                                          <?php endif; ?>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $customer->customerRevenue($customer->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revenue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                       <tr class="font-style">
                                          <td><?php echo e(company_date_formate($revenue->date)); ?></td>
                                          <td><?php echo e(currency_format_with_sym($revenue->amount)); ?></td>
                                          <td><?php echo e(!empty($revenue->bankAccount) ? $revenue->bankAccount->bank_name . ' ' . $revenue->bankAccount->holder_name : ''); ?>

                                          </td>
                                          <?php if(module_is_active('ProductService')): ?>
                                          <td><?php echo e(!empty($revenue->category) ? $revenue->category->name : '-'); ?>

                                          </td>
                                          <?php else: ?>
                                          <td>-</td>
                                          <?php endif; ?>
                                          <td><?php echo e(!empty($revenue->reference) ? $revenue->reference : '-'); ?>

                                          </td>
                                          <td>
                                             <p
                                                style="white-space: nowrap;
                                                width: 200px;
                                                overflow: hidden;
                                                text-overflow: ellipsis;">
                                                <?php echo e(!empty($revenue->description) ? $revenue->description : ''); ?>

                                             </p>
                                          </td>
                                          <td>
                                             <?php if(!empty($revenue->add_receipt)): ?>
                                             <div class="action-btn  me-2">
                                                <a href="<?php echo e(get_file($revenue->add_receipt)); ?>"
                                                   download=""
                                                   class="mx-3 btn bg-primary btn-sm align-items-center"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Download')); ?>"
                                                   target="_blank">
                                                <i class="ti ti-download text-white"></i>
                                                </a>
                                             </div>
                                             <div class="action-btn  me-2">
                                                <a href="<?php echo e(get_file($revenue->add_receipt)); ?>"
                                                   class="mx-3 btn bg-secondary btn-sm align-items-center"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Show')); ?>"
                                                   target="_blank">
                                                <i class="ti ti-crosshair text-white"></i>
                                                </a>
                                             </div>
                                             <?php else: ?>
                                             -
                                             <?php endif; ?>
                                          </td>
                                          <?php if(Laratrust::hasPermission('revenue edit') || Laratrust::hasPermission('revenue delete')): ?>
                                          <td class="Action">
                                             <span>
                                                <?php if (app('laratrust')->hasPermission('revenue edit')) : ?>
                                                <div class="action-btn  me-2">
                                                   <a class="mx-3 btn bg-info btn-sm align-items-center"
                                                      data-url="<?php echo e(route('revenue.edit', $revenue->id)); ?>"
                                                      data-ajax-popup="true" data-size="lg"
                                                      data-bs-toggle="tooltip" t
                                                      title="<?php echo e(__('Edit')); ?>"
                                                      data-title="<?php echo e(__('Edit Revenue')); ?>">
                                                   <i class="ti ti-pencil text-white"></i>
                                                   </a>
                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                                <?php if (app('laratrust')->hasPermission('revenue delete')) : ?>
                                                <div class="action-btn me-2">
                                                   <?php echo e(Form::open(['route' => ['revenue.destroy', $revenue->id], 'class' => 'm-0'])); ?>

                                                   <?php echo method_field('DELETE'); ?>
                                                   <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                      data-bs-toggle="tooltip"
                                                      title=""
                                                      data-bs-original-title="Delete"
                                                      aria-label="Delete"
                                                      data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                      data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                      data-confirm-yes="delete-form-<?php echo e($revenue->id); ?>"><i
                                                      class="ti ti-trash text-white text-white"></i></a>
                                                   <?php echo e(Form::close()); ?>

                                                </div>
                                                <?php endif; // app('laratrust')->permission ?>
                                             </span>
                                          </td>
                                          <?php endif; ?>
                                       </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                       <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                       <?php endif; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php echo $__env->yieldPushContent('customer_project_div'); ?>
               <div class="tab-pane fade" id="statement" role="tabpanel" aria-labelledby="pills-user-tab-4">
                  <div class="row">
                     <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card bg-none invo-tab">
                           <div class="card-body">
                              <h3 class="small-title"><?php echo e($customer['name'] . ' ' . __('Statement')); ?></h3>
                              <div class="row issue_date">
                                 <div class="col-md-12">
                                    <div class="issue_date_main">
                                       <div class="form-group">
                                          <?php echo e(Form::label('from_date', __('From Date'), ['class' => 'form-label'])); ?><span
                                             class="text-danger">*</span>
                                          <?php echo e(Form::date('from_date', isset($data['from_date']) ? $data['from_date'] : null, ['class' => 'form-control from_date ', 'required' => 'required'])); ?>

                                       </div>
                                    </div>
                                    <div class="issue_date_main">
                                       <div class="form-group">
                                          <?php echo e(Form::label('until_date', __('Until Date'), ['class' => 'form-label'])); ?><span
                                             class="text-danger">*</span>
                                          <?php echo e(Form::date('until_date', isset($data['until_date']) ? $data['until_date'] : null, ['class' => 'form-control until_date', 'required' => 'required'])); ?>

                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12 text-end">
                                 <input type="submit" value="<?php echo e(__('Apply')); ?>"
                                    class="btn btn-sm btn-primary apply_btn">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-8 col-lg-8 col-xl-8">
                        <span>
                           <div class="card">
                              <div class="text-end p-3">
                                 <a class="btn btn-sm btn-primary" onclick="saveAsPDF()"
                                    data-bs-toggle="tooltip"
                                    data-bs-original-title="<?php echo e(__('Download')); ?>">
                                 <i class="ti ti-download"></i>
                                 </a>
                              </div>
                              <div class="card-body" id="printableArea">
                                 <div class="invoice">
                                    <div class="invoice-print">
                                       <div class="row invoice-title mt-2">
                                          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12">
                                             <img src="<?php echo e(get_file(sidebar_logo())); ?>"
                                                alt="<?php echo e(config('app.name', 'WorkDo')); ?>"
                                                class="logo logo-lg" style="max-width: 250px">
                                          </div>
                                          <div
                                             class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 text-end">
                                             <strong><?php echo e(__('My Company')); ?></strong><br>
                                             <h6 class="invoice-number"><?php echo e(\Auth::user()->email); ?>

                                             </h6>
                                             <p>
                                                <?php if(!empty($settings['company_address'])): ?>
                                                <?php echo e($settings['company_address']); ?>

                                                <?php endif; ?>
                                                <?php if(!empty($settings['company_city'])): ?>
                                                <br> <?php echo e($settings['company_city']); ?>,
                                                <?php endif; ?>
                                                <?php if(!empty($settings['company_state'])): ?>
                                                <?php echo e($settings['company_state']); ?>

                                                <?php endif; ?>
                                                <?php if(!empty($settings['company_country'])): ?>
                                                <br><?php echo e($settings['company_country']); ?>

                                                <?php endif; ?>
                                                <?php if(!empty($settings['company_zipcode'])): ?>
                                                - <?php echo e($settings['company_zipcode']); ?>

                                                <?php endif; ?>
                                             </p>
                                          </div>
                                          <div
                                             class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-12 text-center">
                                             <strong>
                                                <h5><?php echo e(__('Statement of Account')); ?></h5>
                                             </strong>
                                             <strong><?php echo e($data['from_date'] . '  ' . 'to' . '  ' . $data['until_date']); ?></strong>
                                          </div>
                                          <div class="col-12">
                                             <hr>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-8">
                                             <h5 class="invoice-number"><?php echo e($customer['name']); ?></h5>
                                          </div>
                                          <div class="col-md-4">
                                             <h5 class="invoice-number"><?php echo e(__('Account summary')); ?>

                                             </h5>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-12">
                                             <div class="row">
                                                <?php if(!empty($customer->billing_name)): ?>
                                                <div class="col-md-4">
                                                   <small class="font-style">
                                                   <strong><?php echo e(__('Billed To')); ?>

                                                   :</strong><br>
                                                   <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?><br>
                                                   <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?><br>
                                                   <?php echo e(!empty($customer->billing_city) ? $customer->billing_city . ' ,' : ''); ?>

                                                   <?php echo e(!empty($customer->billing_state) ? $customer->billing_state . ' ,' : ''); ?>

                                                   <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?><br>
                                                   <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?><br>
                                                   <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?><br>
                                                   <strong><?php echo e(__('Tax Number ')); ?> :
                                                   </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                   </small>
                                                </div>
                                                <?php endif; ?>
                                                <?php if($company_settings['invoice_shipping_display'] == 'on' || $company_settings['proposal_shipping_display'] == 'on'): ?>
                                                <div class="col-md-4 text-end">
                                                   <small>
                                                   <strong><?php echo e(__('Shipped To')); ?>

                                                   </strong><br>
                                                   <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?><br>
                                                   <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?><br>
                                                   <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city . ' ,' : ''); ?>

                                                   <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state . ' ,' : ''); ?>

                                                   <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?><br>
                                                   <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?><br>
                                                   <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?><br>
                                                   <strong><?php echo e(__('Tax Number ')); ?> :
                                                   </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                                   </small>
                                                </div>
                                                <?php endif; ?>
                                             </div>
                                          </div>

                                          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-12">
                                            <?php
                                            $total = 0;
                                            ?>

                                            <?php $__currentLoopData = $invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $total += $payment->amount;
                                            ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $duebalance = $totalInvoiceSum - $total;
                                            ?>
                                                <p class="card-text mb-0"><?php echo e(__('Balance')); ?> :  <span> <?php echo e(currency_format_with_sym($customer['balance'])); ?></span></p>
                                                <p class="card-text mb-0"><?php echo e(__('Invoiced amount')); ?> :  <span> <?php echo e(currency_format_with_sym($totalInvoiceSum)); ?></span></p>
                                                <p class="card-text mb-0"><?php echo e(__('Amount Paid')); ?> :  <span><?php echo e(currency_format_with_sym($total)); ?></span></p>
                                                <p class="card-text mb-0"><?php echo e(__('Balance Due')); ?> :  <span><?php echo e(currency_format_with_sym($duebalance)); ?></span></p>

                                          </div>
                                       </div>
                                       <div class="card mt-4">
                                          <div class="card-body table-border-styletable-border-style">
                                             <div class="table-responsive">
                                                <div id="statement-history">
                                                   <table
                                                      class="table align-items-center table_header">
                                                      <thead>
                                                         <tr>
                                                            <th scope="col">
                                                               <?php echo e(__('Date')); ?>

                                                            </th>
                                                            <th scope="col">
                                                               <?php echo e(__('Invoice')); ?>

                                                            </th>
                                                            <th scope="col">
                                                               <?php echo e(__('Payment Type')); ?>

                                                            </th>
                                                            <th scope="col">
                                                               <?php echo e(__('Amount')); ?>

                                                            </th>
                                                         </tr>
                                                      </thead>
                                                      <tbody class="list">
                                                         <?php
                                                         $total = 0;
                                                         ?>
                                                         <?php $__empty_1 = true; $__currentLoopData = $invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                         <tr>
                                                            <td><?php echo e(company_date_formate($payment->date)); ?>

                                                            </td>
                                                            <td><?php echo e(\App\Models\Invoice::invoiceNumberFormat($payment->invoice_id)); ?>

                                                            </td>
                                                            <td><?php echo e($payment->payment_type); ?>

                                                            </td>
                                                            <td> <?php echo e(currency_format_with_sym($payment->amount)); ?>

                                                            </td>
                                                         </tr>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                         <tr>
                                                            <td colspan="6"
                                                               class="text-center text-dark">
                                                               <p><?php echo e(__('No Data Found')); ?>

                                                               </p>
                                                            </td>
                                                         </tr>
                                                         <?php endif; ?>
                                                      </tbody>
                                                      <tfoot>
                                                         <tr class="total">
                                                            <td class="light_blue">
                                                               <span></span><strong><?php echo e(__('TOTAL :')); ?></strong>
                                                            </td>
                                                            <td class="light_blue"></td>
                                                            <td class="light_blue"></td>
                                                            <?php $__currentLoopData = $invoice_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                            $total += $payment->amount;
                                                            ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <td class="light_blue"
                                                               id="total-amount">
                                                               <span></span><strong><?php echo e(currency_format_with_sym($total)); ?></strong>
                                                            </td>
                                                         </tr>
                                                      </tfoot>
                                                   </table>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customer\show.blade.php ENDPATH**/ ?>