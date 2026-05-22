

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Discipleship Analytics Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
        <a href="<?php echo e(route('discipleship.progress')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-eye"></i> <?php echo e(__('')); ?>

        </a>
        <a href="<?php echo e(route('discipleship.index')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-tool"> Setup</i> 
        </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="row row-gap mb-4">
            <!-- Church Overview Card -->
            <div class="col-xl-6 col-12">
                <div class="dashboard-card">
                    <img src="<?php echo e(asset('assets/images/layer.png')); ?>" class="dashboard-card-layer" alt="layer">
                    <div class="card-inner">
                        <div class="card-content">
                            <h2><?php echo e(Auth::user()->ActiveWorkspaceName()); ?></h2>
                                <p><?php echo e(__('Then Jesus said to His disciples, ‘Whoever wants to be My disciple must deny themselves and take up their cross and follow Me..')); ?></p>
                            <div class="btn-wrp d-flex gap-3">
                                <a href="javascript:" class="btn btn-primary d-flex align-items-center gap-1 cp_link" tabindex="0" data-link="<?php echo e(route('feedback.create')); ?>" data-bs-whatever="Copy Link" data-bs-toggle="tooltip" data-bs-original-title="" title="">
                                    <i class="ti ti-book text-white"></i>
                                <span>Matthew 16:24 (NIV)</span></a>
                                <!-- <a href="javascript:" class="btn btn-primary" tabindex="0">
                                    <i class="ti ti-share text-white"></i>
                                </a> -->
                            </div>
                        </div>
                        <div class="card-icon  d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="63" height="70" viewBox="0 0 63 70" fill="none">
                                <path opacity="0.6" d="M43.3204 60.5504L35.571 68.311C33.3217 70.5635 29.6749 70.5635 27.4294 68.311L19.68 60.5504C17.6533 58.5209 14.4442 58.2942 12.1527 60.0162L6.93626 63.933C4.40676 65.8318 0.794922 64.0252 0.794922 60.858V9.95489C0.794922 6.78762 4.40676 4.9811 6.93626 6.87992L12.1527 10.7967C14.4442 12.5187 17.6533 12.292 19.68 10.2625L27.4294 2.50184C29.6787 0.249388 33.3256 0.249388 35.571 2.50184L43.3204 10.2625C45.3471 12.292 48.5562 12.5187 50.8478 10.7967L56.0642 6.87992C58.5937 4.9811 62.2055 6.78762 62.2055 9.95489V60.858C62.2055 64.0252 58.5937 65.8318 56.0642 63.933L50.8478 60.0162C48.5562 58.2942 45.3471 58.5209 43.3204 60.5504Z" fill="#18BF6B"></path>
                                <path d="M46.8516 30.6055H27.6596C26.0705 30.6055 24.7808 29.314 24.7808 27.7227C24.7808 26.1314 26.0705 24.8398 27.6596 24.8398H46.8516C48.4407 24.8398 49.7304 26.1314 49.7304 27.7227C49.7304 29.314 48.4407 30.6055 46.8516 30.6055ZM49.7304 43.0977C49.7304 41.5064 48.4407 40.2149 46.8516 40.2149H27.6596C26.0705 40.2149 24.7808 41.5064 24.7808 43.0977C24.7808 44.6891 26.0705 45.9806 27.6596 45.9806H46.8516C48.4407 45.9806 49.7304 44.6891 49.7304 43.0977ZM16.1444 24.8398C14.5553 24.8398 13.2656 26.1314 13.2656 27.7227C13.2656 29.314 14.5553 30.6055 16.1444 30.6055C17.7335 30.6055 19.0232 29.314 19.0232 27.7227C19.0232 26.1314 17.7335 24.8398 16.1444 24.8398ZM16.1444 40.2149C14.5553 40.2149 13.2656 41.5064 13.2656 43.0977C13.2656 44.6891 14.5553 45.9806 16.1444 45.9806C17.7335 45.9806 19.0232 44.6891 19.0232 43.0977C19.0232 41.5064 17.7335 40.2149 16.1444 40.2149Z" fill="#18BF6B"></path>
                            </svg>
                        </div>
                    </div>
                </div>    
            </div>
            


 <!-- Mini Cards -->
        <!-- Feedback Mini Cards -->
        <div class="col-xl-6 col-12">
            <div class="row dashboard-wrp">
     
                <?php
                
                    $feedbackStats = [
                      
                        ['label' => 'Pending Reviews', 'icon' => 'ti ti-clock', 'count' => $statswithcount['pending'] ?? 0, 'color' => 'text-danger'],
                        ['label' => 'Resolved', 'icon' => 'ti ti-check', 'count' => $statswithcount['resolved'] ?? 0, 'color' => 'text-success'],
                        ['label' => 'Reviewed', 'icon' => 'ti ti-eye-check', 'count' => $statswithcount['reviewed'] ?? 0, 'color' => 'text-warning'],
                        ['label' => 'Total Feedbacks', 'icon' => 'ti ti-message-dots', 'count' => $statswithcount['total'] ?? 0, 'color' => 'text-primary'],
                        
                    ];
                ?>

              
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="dashboard-project-card">
                            <div class="card-inner  d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="ti ti-clock text-danger"></i>
                                    </div>
                                    <a href="#">
                                        <h6 class="mt-3 mb-0 text-danger">Avg Completion</h6>
                                    </a>
                                </div>
                                <h3 class="mb-0"><?php echo e($avgCompletion); ?>%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="dashboard-project-card">
                            <div class="card-inner  d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="ti ti-check text-success"></i>
                                    </div>
                                    <a href="#">
                                        <h6 class="mt-3 mb-0 text-success">Total Members</h6>
                                    </a>
                                </div>
                                <h3 class="mb-0"><?php echo e($totalMembers); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="dashboard-project-card">
                            <div class="card-inner  d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="ti ti-eye-check text-warning"></i>
                                    </div>
                                    <a href="#">
                                        <h6 class="mt-3 mb-0 text-warning">Pending Approvals</h6>
                                    </a>
                                </div>
                                <h3 class="mb-0"><?php echo e($pendingApprovals); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="dashboard-project-card">
                            <div class="card-inner  d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="ti ti-message-dots text-primary"></i>
                                    </div>
                                    <a href="#">
                                        <h6 class="mt-3 mb-0 text-primary">Completed</h6>
                                    </a>
                                </div>
                                <h3 class="mb-0"><?php echo e($completed); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         



<div class="row">
    <div class="col-sm-12">
        
        <div class="row">
            
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="ti ti-chart-pie text-info"></i> Stage Distribution</h6>
                        <div id="stagePie" style="height:250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="ti ti-bar-chart text-success"></i> Stage Completion %</h6>
                        <div id="stageChart" style="height:250px;"></div>
                    </div>
                </div>
            </div>
            
             <div class="col-md-6">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="ti ti-stairs text-primary"></i> Stage Funnel</h6>
                        <div id="funnelChart" style="height:300px;"></div>
                    </div>
                </div>
            </div>

        
         <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-flame text-danger"></i> Requirement Drop-off Heatmap</h6>
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr><th>Requirement</th><th class="text-end">Drop Rate %</th></tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reqHeatmap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($r['title']); ?></td>
                                    <td class="text-end"><span class="badge bg-danger"><?php echo e($r['drop_rate']); ?>%</span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        


        
         <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-trophy text-warning"></i> Top Members by Points</h6>
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light"><tr><th>Member</th><th class="text-end">Points</th></tr></thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $leaderboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($m->name); ?></td>
                                    <td class="text-end"><span class="badge bg-success"><?php echo e($m->points_total); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-user-check text-primary"></i> Mentor Activity</h6>
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light"><tr><th>Mentor</th><th class="text-end">Approvals</th></tr></thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($m->name); ?></td>
                                    <td class="text-end"><span class="badge bg-primary"><?php echo e($m->approvals_count); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-alert-triangle text-danger"></i> At-Risk Members (Stalled >30 days)</h6>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stalledMembers->count()): ?>
                        <ul class="list-group list-group-flush">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stalledMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($s->member->name); ?>

                                    <span class="badge bg-warning"><?php echo e($s->stage->name); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    <?php else: ?> 
                        <p class="text-muted">No stalled members 🎉</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div> 
        </div>
        
        
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-building-community text-info"></i> Department Engagement</h6>
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $deptStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Department <?php echo e($d->department_id); ?>

                                <span class="badge bg-secondary"><?php echo e($d->total); ?> Members</span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        
        
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-calendar-stats text-success"></i> Completions Over Time</h6>
                    <div id="timelineChart" style="height:300px;"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="ti ti-bulb text-warning"></i> Smart Suggestions</h6>
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item"><?php echo e($s); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>






<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Funnel Chart
    new ApexCharts(document.querySelector("#funnelChart"), {
        chart:{ type:'bar', height:300 },
        plotOptions:{ bar:{ horizontal:true, distributed:true } },
        colors:['#007bff','#28a745','#17a2b8','#ffc107','#dc3545'],
        series:[{ name:'Completed', data:<?php echo json_encode($stages->pluck('completed_count'), 15, 512) ?> }],
        xaxis:{ categories:<?php echo json_encode($stages->pluck('name'), 15, 512) ?> }
    }).render();

    // Stage Completion Bar
    new ApexCharts(document.querySelector("#stageChart"), {
        chart:{ type:'bar', height:250 },
        colors:['#28a745'],
        series:[{ name:'Completion %', data:<?php echo json_encode($stageCompletionRates->pluck('completion'), 15, 512) ?> }],
        xaxis:{ categories:<?php echo json_encode($stageCompletionRates->pluck('stage'), 15, 512) ?> }
    }).render();

    // Stage Pie Distribution
    new ApexCharts(document.querySelector("#stagePie"), {
        chart:{ type:'pie', height:250 },
        series:<?php echo json_encode($stages->pluck('started_count'), 15, 512) ?>,
        labels:<?php echo json_encode($stages->pluck('name'), 15, 512) ?>,
        colors:['#007bff','#28a745','#17a2b8','#ffc107','#dc3545']
    }).render();

    // Timeline
    new ApexCharts(document.querySelector("#timelineChart"), {
        chart:{ type:'line', height:300 },
        stroke:{ curve:'smooth' },
        colors:['#007bff'],
        series:[{ name:'Completions', data:<?php echo json_encode($timeline->pluck('total'), 15, 512) ?> }],
        xaxis:{ categories:<?php echo json_encode($timeline->pluck('date'), 15, 512) ?> }
    }).render();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\discipleship\dashboard.blade.php ENDPATH**/ ?>