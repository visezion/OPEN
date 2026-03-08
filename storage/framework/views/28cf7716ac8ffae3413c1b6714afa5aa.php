

<?php $__env->startSection('page-title', __("$member->name Profile")); ?>


<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('members.edit', Crypt::encrypt($member->id))); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-pencil"></i> <?php echo e(__('Edit Profile')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <!-- Profile Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <!-- Small Avatar (list view style) -->
                  
                    <img 
                        src="<?php echo e($member->profile_photo 
                            ? asset('storage/'.$member->profile_photo) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=random'); ?>" 
                        alt="Profile Picture"
                        class="rounded-circle shadow-sm border"
                        style="width:150px; height:150px; object-fit:cover; padding:15px; margin-right:20px;"
                    >

                    

                    <div>
                        <h4 class="mb-0"><?php echo e($member->name); ?></h4>
                        <small><?php echo e($member->email); ?> | <?php echo e($member->phone); ?></small>
                        <div class="mt-2">
                            <span class="badge <?php echo e($member->is_active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($member->is_active ? __('Active') : __('Inactive')); ?>

                            </span>
                            <span class="ms-2"><?php echo e(__('Member since:')); ?> <?php echo e($member->created_at->format('M Y')); ?></span>
                        </div>
                    </div>
                </div>

                
                <div class="text-end">
                    <!-- Quick Actions -->
                    <a href="tel:<?php echo e($member->phone); ?>" class="btn btn-outline-primary btn-sm"><i class="ti ti-phone"></i></a>
                    <a href="mailto:<?php echo e($member->email); ?>" class="btn btn-outline-primary btn-sm"><i class="ti ti-mail"></i></a>
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ti ti-brand-whatsapp"></i></a>
                    <a href="#" class="btn btn-outline-secondary btn-sm"><i class="ti ti-download"></i> PDF</a>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview"><?php echo e(__('Overview')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#church"><?php echo e(__('Church Info')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#family"><?php echo e(__('Family Tree')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#teams"><?php echo e(__('Teams')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#donations"><?php echo e(__('Donations')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendance"><?php echo e(__('Attendance')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity"><?php echo e(__('Activity')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#care"><?php echo e(__('Pastoral Care')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#smart-tags"><?php echo e(__('Smart Tags')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#discipleship"><?php echo e(__('Discipleship')); ?></button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#custom"><?php echo e(__('Custom Fields')); ?></button></li>
        </ul>

        <div class="tab-content">
            <!-- Overview -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        
                        <div class="card p-3 mb-3 shadow-sm border-0">
                            <h6><i class="ti ti-user-check"></i> <?php echo e(__('Profile Completion')); ?></h6>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-primary" style="width: <?php echo e($completion); ?>%"></div>
                            </div>
                            <small><?php echo e($completion); ?>% <?php echo e(__('Completed')); ?></small>

                            <?php if($completion < 100): ?>
                                <ul class="mt-2 text-danger small">
                                    <?php $__currentLoopData = $missingFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($field); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        
                        <div class="card p-3 mb-3 shadow-sm border-0">
                            <h6><i class="ti ti-activity-heartbeat"></i> <?php echo e(__('Engagement Score')); ?></h6>
                            <h3 class="text-primary"><?php echo e($engagementScore); ?>/100</h3>
                            <small><?php echo e(__('Based on attendance, giving, volunteering')); ?></small>
                        </div>

                        

                        
                        <div class="card p-3 mb-3 shadow-sm border-0" >
                            <h6 class="mb-3">
                                <i class="ti ti-building-church text-primary"></i>
                                <?php echo e(__('Branch & Ministries')); ?>

                            </h6>

                            
                            <div class="mb-1">
                                <i class="ti ti-home-heart text-success"></i>
                                <strong><?php echo e(__('Branch:')); ?></strong>
                                <span class="text-dark"><?php echo e($member->branch->name ?? __('Not Assigned')); ?></span>
                            </div>

                            
                            <?php if($member->departments && $member->departments->count()): ?>
                                <div class="list-group list-group-flush" >
                                    <?php $__currentLoopData = $member->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item border-0 px-0 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <i class="ti ti-users text-info me-2"></i>
                                                    <span class="fw-semibold"><?php echo e($dept->name); ?></span>
                                                    <?php if($dept->pivot && $dept->pivot->designation_id): ?>
                                                        <span class="badge bg-light text-dark ms-2">
                                                            <i class="ti ti-id-badge text-muted"></i>
                                                            <?php echo e(optional(\Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id))->name); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            
                                            <div class="mt-2" >
                                                <?php
                                                    $mates = $dept->members()
                                                        ->where('church_members.id', '!=', $member->id) // exclude current member
                                                        ->limit(5)
                                                        ->get();
                                                ?>

                                                <?php if($mates->count()): ?>
                                                    <div class="d-flex align-items-center">
                                                        <div style="margin-left:30px;"></div>
                                                        <?php $__currentLoopData = $mates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <img src="<?php echo e($mate->profile_photo 
                                                                ? asset('storage/'.$mate->profile_photo) 
                                                                : 'https://ui-avatars.com/api/?name='.urlencode($mate->name).'&size=50&background=random'); ?>"
                                                                class="rounded-circle border border-white"
                                                                style="width:30px; height:30px; object-fit:cover; margin-left:-10px; z-index:<?php echo e(10 - $index); ?>;"
                                                                title="<?php echo e($mate->name); ?>">
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if($dept->members()->count() > 5): ?>
                                                            <span class="rounded-circle bg-primary text-white small d-flex align-items-center justify-content-center border border-white"
                                                                style="width:35px; height:35px; margin-left:-10px;">
                                                                +<?php echo e($dept->members()->count() - 5); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="text-muted small mb-0"><?php echo e(__('No other members in this department.')); ?></p>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">
                                    <i class="ti ti-circle-dashed"></i> <?php echo e(__('No departments or designations assigned.')); ?>

                                </p>
                            <?php endif; ?>
                        </div>


                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="row">
                            
                            <div class="col-md-9 mb-3">
                                <div class="card p-4 shadow-sm border-0 text-center h-100">
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <div class="rounded-circle bg-light p-3 shadow-sm">
                                            <i class="ti ti-cake text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold mb-3"><?php echo e(__('Birthday Countdown')); ?></h5>

                                    <?php if($birthdayCountdown !== null): ?>
                                        <?php if($birthdayCountdown == 0): ?>
                                            <h4 class="text-success fw-bold mb-2">🎉 Happy Birthday <?php echo e($member->name); ?>! 🎂</h4>
                                            <p class="text-muted">Wishing you joy, health and blessings today.</p>
                                        <?php else: ?>
                                            <p class="text-muted mb-3">
                                                🎂 <?php echo e($member->name); ?>’s birthday is on 
                                                <strong class="text-dark"><?php echo e($birthdayDate); ?></strong> 
                                                (<?php echo e($birthdayCountdown); ?> days left)
                                            </p>
                                            
                                            <div class="d-flex justify-content-between">
                                                <?php $__currentLoopData = range(1,12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="text-center flex-fill">
                                                        <div class="rounded-circle 
                                                            <?php echo e($m == $birthdayMonth ? 'bg-success text-white' : ($m == now()->month ? 'bg-primary text-white' : 'bg-light')); ?>

                                                            d-inline-flex align-items-center justify-content-center shadow-sm"
                                                            style="width:35px;height:35px;">
                                                            <?php echo e(substr(\Carbon\Carbon::create()->month($m)->format('M'),0,1)); ?>

                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted fst-italic">No date of birth provided.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="col-md-3 mb-3">
                                <div class="card p-3 shadow-sm border-0 text-center h-100">
                                    <h6 class="mb-3"><i class="ti ti-send text-success me-2"></i> <?php echo e(__('Quick Actions')); ?></h6>
                                    <div class="d-grid gap-2">
                                        <a href="" class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-message"></i> <?php echo e(__('Message')); ?>

                                        </a>
                                        <a href="" class="btn btn-outline-success btn-sm">
                                            <i class="ti ti-heart-dollar"></i> <?php echo e(__('Donation')); ?>

                                        </a>
                                        <a href="" class="btn btn-outline-warning btn-sm">
                                            <i class="ti ti-calendar-check"></i> <?php echo e(__('Attendance')); ?>

                                        </a>
                                        <a href="<?php echo e(route('members.edit', Crypt::encrypt($member->id))); ?>" class="btn btn-outline-secondary btn-sm">
                                            <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-12">
                                <div class="card p-3 shadow-sm border-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-clock text-primary me-2"></i>
                                        <h6 class="mb-0"><?php echo e(__('Recent Activity')); ?></h6>
                                    </div>

                                    <?php if($activities && $activities->count()): ?>
                                        <ul class="timeline list-unstyled small ps-3">
                                            <?php $__currentLoopData = $activities->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="mb-2">
                                                    <span class="fw-bold"><?php echo e(ucfirst($act->type ?? 'Activity')); ?></span> – 
                                                    <?php echo e($act->description); ?>

                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="ti ti-calendar"></i> <?php echo e($act->created_at->diffForHumans()); ?>

                                                    </small>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <a href="#" class="small text-primary">
                                            <i class="ti ti-list"></i> <?php echo e(__('View all activities')); ?>

                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted fst-italic"><?php echo e(__('No recent activity logged.')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Church Info -->
            <div class="tab-pane fade" id="church">
                <div class="card p-4 shadow-sm border-0">
                    <div class="row">
                        <!-- Left: Church Details -->
                        <div class="col-md-3 border-end">
                            <h6 class="mb-3">
                                <div class="card p-4 shadow-sm border-0">
                                <i class="ti ti-building-church text-primary"></i>
                                <?php echo e(__('Church Details')); ?>

                            </h6>
                            <div class="card p-4 shadow-sm border-0">
                            <p><strong><i class="ti ti-brand-whatsapp text-success"></i> <?php echo e(__('Group ID:')); ?></strong> <?php echo e($member->group_id); ?></p>
                            <p><strong><i class="ti ti-id text-muted"></i> <?php echo e(__('Member ID:')); ?></strong> <?php echo e($member->member_id); ?></p>
                            <p><strong><i class="ti ti-home-heart text-success"></i> <?php echo e(__('Branch:')); ?></strong>
                                <?php echo e($member->branch?->name ?? __('Not Assigned')); ?>

                            </p>

                            
                            <?php if($member->departments && $member->departments->count()): ?>
                                <?php $__currentLoopData = $member->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="mb-3">
                                        <p class="mb-1">
                                            <i class="ti ti-users text-info"></i>
                                            <strong><?php echo e($dept->name); ?></strong>
                                            <?php if($dept->pivot && $dept->pivot->designation_id): ?>
                                                <span class="badge bg-light text-dark ms-2">
                                                    <i class="ti ti-id-badge"></i>
                                                    <?php echo e(optional(\Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id))->name); ?>

                                                </span>
                                            <?php endif; ?>
                                        </p>

                                        
                                        <?php
                                            $mates = $dept->members()->where('church_members.id', '!=', $member->id)->get();
                                            $totalMates = $mates->count();
                                        ?>

                                        <?php if($totalMates): ?>
                                            <div class="d-flex align-items-center mb-1">
                                                <?php $__currentLoopData = $mates->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('members.show', Crypt::encrypt($mate->id))); ?>" title="<?php echo e($mate->name); ?>">
                                                        <img src="<?php echo e($mate->profile_photo
                                                            ? asset('storage/'.$mate->profile_photo)
                                                            : 'https://ui-avatars.com/api/?name='.urlencode($mate->name).'&size=50&background=random'); ?>"
                                                            class="rounded-circle border border-white"
                                                            style="width:35px; height:35px; object-fit:cover; margin-left:-10px; z-index:<?php echo e(10 - $index); ?>;">
                                                    </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($totalMates > 5): ?>
                                                    <span class="rounded-circle bg-primary text-white small d-flex align-items-center justify-content-center border border-white"
                                                        style="width:35px; height:35px; margin-left:-10px;">
                                                        +<?php echo e($totalMates - 5); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted"><?php echo e($totalMates); ?> <?php echo e(Str::plural('teammate', $totalMates)); ?> in this department</small>
                                        <?php else: ?>
                                            <p class="text-muted small mb-0"><?php echo e(__('No other members in this department.')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">
                                    <i class="ti ti-circle-dashed"></i> <?php echo e(__('No departments or designations assigned.')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                        <!-- Right: Appreciation Note -->
                    <div class="col-md-9 d-flex align-items-center">
                            <div class="p-4 bg-light rounded shadow-sm">
                                <h6 class="text-primary mb-3">
                                    <i class="ti ti-heart text-danger"></i> <?php echo e(__('A Personal Letter to a Cherished Family Member')); ?>

                                </h6>

                                
                                <p class="small text-muted mb-3">
                                    Dear <strong><?php echo e($member->name); ?></strong>,
                                </p>

                                
                                <p class="small text-muted mb-3">
                                    From the moment you joined us on
                                    <strong><?php echo e($member->church_doj ? \Carbon\Carbon::parse($member->church_doj)->format('F j, Y') : __('N/A')); ?></strong>,  
                                    you became more than a record in our books you became a beloved member of this spiritual family.  
                                    We thank God for guiding your steps to this house, and for every way you have contributed to the growth of our community.  
                                </p>

                                
                                <p class="small text-muted mb-3">
                                    As part of our <strong><?php echo e($member->branch?->name ?? 'Main'); ?></strong> branch, you have stood as a light among your brothers and sisters.  
                                    Your current status as <strong><?php echo e($member->membership_status ?? 'Active'); ?></strong> reminds us of your commitment to walk faithfully with us.  
                                </p>

                                
                                <?php if($member->departments && $member->departments->count()): ?>
                                    <p class="small text-muted mb-3">
                                        We also honor your service in the following ministries:  
                                        <?php $__currentLoopData = $member->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <br> • <strong><?php echo e($dept->name); ?></strong>
                                            <?php if($dept->pivot?->designation_id): ?>
                                                — <?php echo e(\Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id)?->name); ?>

                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                <?php endif; ?>

                                
                                <?php if($member->spouse): ?>
                                    <p class="small text-muted mb-3">
                                        Together with your spouse, <strong><?php echo e($member->spouse?->name); ?></strong>,  
                                        your household is a living testimony of God’s grace.  
                                    </p>
                                <?php elseif($member->family): ?>
                                    <p class="small text-muted mb-3">
                                        As part of the <strong><?php echo e($member->family?->name); ?></strong> family group,  
                                        you have enriched our church not only as an individual but also as a pillar of your household.  
                                    </p>
                                <?php endif; ?>

                                
                                <p class="small text-muted mb-3">
                                    Your role as <strong><?php echo e($member->designation?->name ?? 'a committed servant of Christ'); ?></strong>  
                                    inspires others to serve with humility, love, and strength. Every department you’ve touched and every team you’ve joined  
                                    has been strengthened because of your presence and dedication.  
                                </p>

                                
                                <p class="small text-muted mb-3">
                                    Thank you, <strong><?php echo e($member->name); ?></strong>, for being more than just a member.  
                                    Thank you for being family our brother/sister, our encourager, and a true vessel of God’s work.  
                                    We look forward to many more years of fellowship, growth, and testimony with you by our side.  
                                </p>

                                
                                <p class="small text-muted mb-0">
                                    With love, honor, and blessings,<br>
                                    <strong>The Founder & Shepherd of this House</strong>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Family Tree -->
            <div class="tab-pane fade" id="family">
                <div class="card p-4 shadow-sm border-0">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-users text-primary fs-5 me-2"></i>
                        <h6 class="mb-0"><?php echo e(__('Family Tree')); ?></h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-7">
                            <div class="border rounded-3 p-3 bg-light">
                                <h5 class="text-primary mb-2"><?php echo e(__('Our Family in Christ')); ?></h5>
                                <p class="mb-2 text-muted">
                                    Beloved <strong><?php echo e($member->name); ?></strong>, this portrait of your spiritual family reminds us that we are bonded not by blood only but by the grace that unites us in Christ. Every branch you touch is nourished by your testimony and service.
                                </p>
                                <p class="mb-2 text-muted fst-italic">
                                    “You are no longer strangers or outsiders. You are citizens with all of God’s holy people. You are members of God’s family, built on the foundation of the apostles and prophets, with Christ Jesus Himself as the cornerstone.” —
                                    <strong>Ephesians 2:19-20</strong>
                                </p>
                                <p class="text-dark fw-semibold mb-0">
                                    Your name shines not just on a page but as a living stone in God’s temple, called to bring light, love, and legacy to every household you influence.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="border rounded-3 p-3 h-100">
                                <h6 class="text-primary mb-3"><?php echo e(__('A Living Lineage')); ?></h6>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-2">
                                        <span class="fw-semibold"><?php echo e(__('Rooted in Prayer')); ?></span>
                                        <p class="text-muted mb-0"><?php echo e(__('Your family branch remains intentional about prayer and intercession for every milestone.')); ?></p>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-semibold"><?php echo e(__('Faithful Servanthood')); ?></span>
                                        <p class="text-muted mb-0"><?php echo e(__('You steward relationships, resources, and ministry responsibilities with excellence.')); ?></p>
                                    </li>
                                    <li>
                                        <span class="fw-semibold"><?php echo e(__('Heirs Together')); ?></span>
                                        <p class="text-muted mb-0"><?php echo e(__('No season is walked alone; your church-family stands beside you in celebration and in trial.')); ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="church-tree" class="mt-4 rounded border border-2 border-dashed" style="min-height:500px;"></div>
                </div>
            </div>

<!-- Teams --><!-- Teams / Departments -->
<div class="tab-pane fade" id="teams">
    <div class="card p-3 shadow-sm border-0">
        <h6 class="mb-5">
            <i class="ti ti-users text-primary"></i> <?php echo e(__('Teams (Departments)')); ?>

        </h6>

        <?php $__empty_1 = true; $__currentLoopData = $member->departments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="mb-4">
                <!-- Department / Team Name -->
                <h6 class="text-dark mb-2">
                    <?php echo e($dept->name); ?>

                    <span class="badge bg-light text-primary"><?php echo e(__('Department')); ?></span>
                </h6>

                <!-- Department Members -->
                <div class="row">
                    <?php $__currentLoopData = $dept->members ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="d-flex align-items-center p-2 border rounded shadow-sm h-100">
                                <!-- Profile Picture -->
                                <img src="<?php echo e($tm->profile_photo 
                                        ? asset('storage/'.$tm->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name='.urlencode($tm->name)); ?>"
                                    class="rounded-circle me-3"
                                    style="width:50px;height:50px;object-fit:cover;">

                                <!-- Member Info -->
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo e($tm->name); ?></h6>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-phone"></i> <?php echo e($tm->phone ?? '-'); ?>

                                    </p>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-gift"></i> 
                                        <?php echo e($tm->dob ? \Carbon\Carbon::parse($tm->dob)->format('M d') : '-'); ?>

                                    </p>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-badge"></i> <?php echo e($tm->pivot->designation_id ? \Workdo\Churchly\Entities\ChurchDesignation::find($tm->pivot->designation_id)->name : 'Member'); ?>

                                    </p>
                                </div>

                                <!-- Action -->
                                <div>
                                    <a href="mailto:<?php echo e($tm->email); ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Send Message">
                                        <i class="ti ti-mail"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted"><?php echo e(__('No departments assigned.')); ?></p>
        <?php endif; ?>
    </div>
</div>


            <!-- Donations -->
            <div class="tab-pane fade" id="donations">
                <div class="card p-3 shadow-sm border-0">
                    <h6><?php echo e(__('Giving Trends')); ?></h6>
                    <canvas id="donationsChart"></canvas>
                </div>
            </div>

            <!-- Attendance -->
            <div class="tab-pane fade" id="attendance">
                <div class="card p-3 shadow-sm border-0">
                    <h6><?php echo e(__('Attendance Calendar')); ?></h6>
                    <div id="attendanceCalendar"></div>
                </div>
            </div>

            <!-- Activity -->
            <div class="tab-pane fade" id="activity">
                <div class="card p-3 shadow-sm border-0">
                    <h6><?php echo e(__('Recent Activity')); ?></h6>
                    <ul class="timeline">
                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><strong><?php echo e($activity->type); ?></strong> — <?php echo e($activity->description); ?> <small class="text-muted">(<?php echo e($activity->created_at->diffForHumans()); ?>)</small></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <!-- Discipleship -->

            <!-- Discipleship -->
<div class="tab-pane fade" id="discipleship">
    <div class="container-fluid py-4 bg-light">
        <div class="row">
            <!-- LEFT SIDE: Flow -->
            <div class="col-lg-7">
                 <div class="p-4 bg-white shadow rounded-3 h-100">
                <div class="text-center mb-5">
                    <h3 class="fw-bold text-dark">
                        <i class="ti ti-map text-success"></i> <?php echo e(__('Discipleship Pathway')); ?>

                    </h3>
                    <p class="text-muted">
                        <?php echo e(__('This flow shows your discipleship journey. Stages are color-coded to show your progress.')); ?>

                    </p>
                </div>

                <div class="d-flex flex-wrap justify-content-center align-items-center">
                    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $progress = $member->progress->where('stage_id', $stage->id)->first();
                            $status = $progress?->status ?? 'pending';
                            $color = $status === 'completed' ? 'success' : ($status === 'active' ? 'warning' : 'primary');
                        ?>

                        <div class="text-center mx-4 mb-5">
                            <div class="rounded-circle bg-<?php echo e($color); ?> text-white fw-bold shadow d-flex align-items-center justify-content-center"
                                style="width:100px; height:100px; font-size:1.25rem;">
                                <?php echo e($stage->order); ?>

                            </div>
                            <div class="mt-3 fw-bold text-dark"><?php echo e($stage->name); ?></div>
                        </div>

                        <?php if(!$loop->last): ?>
                            <i class="ti ti-arrow-right text-secondary fs-3 mx-3"></i>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Legend -->
                <div class="text-center mt-3 mb-5">
                    <span class="badge bg-success px-3 py-2 me-2">Completed</span>
                    <span class="badge bg-warning text-dark px-3 py-2 me-2">Current</span>
                    <span class="badge bg-primary px-3 py-2">Pending</span>
                </div>
            </div>
            </div>

            <!-- RIGHT SIDE: Stage Requirements -->
            <div class="col-lg-5">
                <div class="p-4 bg-white shadow rounded-3 h-100">
                    <h5 class="fw-bold mb-3">
                        <i class="ti ti-list-details text-primary"></i> <?php echo e(__('Stage Requirements')); ?>

                    </h5>
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <b><?php echo e($stage->order); ?>. <?php echo e($stage->name); ?></b>
                                <ul class="text-muted small ps-3 mb-2">
                                    <?php $__empty_1 = true; $__currentLoopData = $stage->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <?php echo e($req->title); ?>

                                            <span class="badge bg-light text-dark"><?php echo e(ucfirst($req->type)); ?></span>
                                            <?php if($req->is_mandatory): ?> 
                                                <span class="badge bg-danger">Mandatory</span>
                                            <?php endif; ?>
                                            <?php if($req->requires_approval): ?> 
                                                <span class="badge bg-warning text-dark">Approval</span>
                                            <?php endif; ?>
                                            <?php if($req->points): ?> 
                                                <span class="badge bg-success"><?php echo e($req->points); ?> pts</span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li><i class="text-muted">No requirements yet.</i></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="mt-3">
                        <a href="<?php echo e(route('discipleship.my_journey')); ?>" 
                        class="btn btn-primary w-100 rounded-pill shadow-sm">
                            <i class="ti ti-arrow-right-circle me-1"></i> <?php echo e(__('Continue')); ?>

                        </a>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
</div>



            <!-- Pastoral Care -->
            <div class="tab-pane fade" id="care">
                <div class="row g-3">
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0"><?php echo e(__('Household & Family')); ?></h6>
                            </div>
                            <div class="card-body">
                                <?php $__empty_1 = true; $__currentLoopData = $households; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $household): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="border rounded p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong><?php echo e($household->name); ?></strong>
                                                <?php if($household->primaryContact && $household->primaryContact->id === $member->id): ?>
                                                    <span class="badge bg-primary ms-1"><?php echo e(__('Primary contact')); ?></span>
                                                <?php endif; ?>
                                                <?php if($household->phone): ?>
                                                    <div class="small text-muted"><?php echo e($household->phone); ?></div>
                                                <?php endif; ?>
                                                <?php if($household->email): ?>
                                                    <div class="small text-muted"><?php echo e($household->email); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <form method="POST" action="<?php echo e(route('churchly.households.members.detach', [$household->id, $member->id])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="ti ti-unlink"></i> <?php echo e(__('Remove')); ?>

                                                </button>
                                            </form>
                                        </div>
                                        <?php if($household->members->isNotEmpty()): ?>
                                            <div class="mt-2 small text-muted">
                                                <?php echo e(__('Members:')); ?>

                                                <?php $__currentLoopData = $household->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $houseMember): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-light text-dark me-1 mb-1">
                                                        <?php echo e($houseMember->name); ?>

                                                        <?php if($houseMember->pivot && $houseMember->pivot->relationship): ?>
                                                            <span class="text-muted">(<?php echo e($houseMember->pivot->relationship); ?>)</span>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-muted"><?php echo e(__('Not yet linked to a household.')); ?></p>
                                <?php endif; ?>

                                <hr class="my-3">
                                <form method="POST" action="<?php echo e(route('churchly.households.members.attach-form')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="member_id" value="<?php echo e($member->id); ?>">
                                    <div class="mb-2">
                                        <label class="form-label"><?php echo e(__('Attach to an existing household')); ?></label>
                                        <div class="input-group">
                                            <select class="form-select" name="household_id" required>
                                                <option value=""><?php echo e(__('Select household')); ?></option>
                                                <?php $__currentLoopData = $availableHouseholds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availableHousehold): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($availableHousehold->id); ?>"><?php echo e($availableHousehold->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <button class="btn btn-outline-primary" type="submit"><?php echo e(__('Attach')); ?></button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="relationship" class="form-control" placeholder="<?php echo e(__('Relationship label (optional)')); ?>">
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="household-primary" name="is_primary" value="1">
                                        <label class="form-check-label" for="household-primary"><?php echo e(__('Set as primary contact')); ?></label>
                                    </div>
                                </form>

                                <hr class="my-3">
                                <form method="POST" action="<?php echo e(route('churchly.households.store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="primary_contact_id" value="<?php echo e($member->id); ?>">
                                    <div class="mb-2">
                                        <label class="form-label"><?php echo e(__('Create new household')); ?></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-6">
                                            <input type="text" name="phone" class="form-control" placeholder="<?php echo e(__('Phone')); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control" placeholder="<?php echo e(__('Email')); ?>">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="notes" class="form-control" rows="2" placeholder="<?php echo e(__('Notes (optional)')); ?>"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary btn-sm"><?php echo e(__('Save Household')); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><?php echo e(__('Follow-up Workflow')); ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo e(route('members.followups.store', $member->id)); ?>" class="row g-2 mb-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-6">
                                        <label class="form-label"><?php echo e(__('Subject')); ?></label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><?php echo e(__('Assign to')); ?></label>
                                        <select name="assigned_to" class="form-select">
                                            <option value=""><?php echo e(__('Unassigned')); ?></option>
                                            <?php $__currentLoopData = $careTeamUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $careUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($careUser->id); ?>"><?php echo e($careUser->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><?php echo e(__('Due date')); ?></label>
                                        <input type="date" name="due_at" class="form-control">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label"><?php echo e(__('Notes')); ?></label>
                                        <textarea name="description" class="form-control" rows="1" placeholder="<?php echo e(__('Context or instructions')); ?>"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                                        <select name="status" class="form-select">
                                            <option value="open"><?php echo e(__('Open')); ?></option>
                                            <option value="in_progress"><?php echo e(__('In progress')); ?></option>
                                            <option value="completed"><?php echo e(__('Completed')); ?></option>
                                            <option value="cancelled"><?php echo e(__('Cancelled')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end justify-content-end">
                                        <button class="btn btn-primary"><?php echo e(__('Create Follow-up')); ?></button>
                                    </div>
                                </form>

                                <hr class="my-3">
                                <?php $__empty_1 = true; $__currentLoopData = $memberFollowUps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followUp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="border rounded p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong><?php echo e($followUp->subject); ?></strong>
                                                <span class="badge bg-secondary ms-2 text-uppercase"><?php echo e(__($followUp->status)); ?></span>
                                                <?php if($followUp->due_at): ?>
                                                    <div class="small text-muted"><?php echo e(__('Due')); ?>: <?php echo e($followUp->due_at->format('M d, Y')); ?></div>
                                                <?php endif; ?>
                                                <?php if($followUp->assignee): ?>
                                                    <div class="small text-muted"><?php echo e(__('Assigned to')); ?>: <?php echo e($followUp->assignee->name); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <form method="POST" action="<?php echo e(route('members.followups.destroy', [$member->id, $followUp->id])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                        <?php if($followUp->description): ?>
                                            <p class="small mt-2 mb-2"><?php echo e($followUp->description); ?></p>
                                        <?php endif; ?>
                                        <form method="POST" action="<?php echo e(route('members.followups.update', [$member->id, $followUp->id])); ?>" class="row g-2">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="subject" value="<?php echo e($followUp->subject); ?>">
                                            <input type="hidden" name="description" value="<?php echo e($followUp->description); ?>">
                                            <div class="col-md-4">
                                                <label class="form-label"><?php echo e(__('Status')); ?></label>
                                                <select name="status" class="form-select form-select-sm">
                                                    <?php $__currentLoopData = ['open','in_progress','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status); ?>" <?php if($followUp->status === $status): echo 'selected'; endif; ?>><?php echo e(__(ucwords(str_replace('_',' ', $status)))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><?php echo e(__('Due date')); ?></label>
                                                <input type="date" name="due_at" value="<?php echo e(optional($followUp->due_at)->format('Y-m-d')); ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><?php echo e(__('Assign to')); ?></label>
                                                <select name="assigned_to" class="form-select form-select-sm">
                                                    <option value=""><?php echo e(__('Unassigned')); ?></option>
                                                    <?php $__currentLoopData = $careTeamUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $careUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($careUser->id); ?>" <?php if($followUp->assigned_to === $careUser->id): echo 'selected'; endif; ?>><?php echo e($careUser->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-sm btn-outline-primary"><?php echo e(__('Update')); ?></button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-muted"><?php echo e(__('No follow-ups recorded yet.')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0"><?php echo e(__('Pastoral Notes')); ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo e(route('members.notes.store', $member->id)); ?>" class="mb-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-2">
                                        <input type="text" name="title" class="form-control" placeholder="<?php echo e(__('Title (optional)')); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="body" class="form-control" rows="3" placeholder="<?php echo e(__('Add a confidential note for the pastoral team')); ?>" required></textarea>
                                    </div>
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label"><?php echo e(__('Visibility')); ?></label>
                                            <select name="visibility" class="form-select">
                                                <option value="staff"><?php echo e(__('Staff')); ?></option>
                                                <option value="pastoral"><?php echo e(__('Pastoral team')); ?></option>
                                                <option value="leaders"><?php echo e(__('Leaders')); ?></option>
                                                <option value="private"><?php echo e(__('Only me')); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-check mt-4">
                                            <input type="checkbox" class="form-check-input" id="requires-attention" name="requires_attention" value="1">
                                            <label class="form-check-label" for="requires-attention"><?php echo e(__('Flag for attention')); ?></label>
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-end mt-4">
                                            <button class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="list-group">
                                    <?php $__empty_1 = true; $__currentLoopData = $memberNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="list-group-item list-group-item-action mb-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong><?php echo e($note->title ?? __('Note')); ?></strong>
                                                    <span class="badge bg-secondary ms-2 text-uppercase"><?php echo e(__($note->visibility)); ?></span>
                                                    <div class="small text-muted"><?php echo e(optional($note->author)->name); ?> · <?php echo e($note->created_at->diffForHumans()); ?></div>
                                                </div>
                                                <form method="POST" action="<?php echo e(route('members.notes.destroy', [$member->id, $note->id])); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                                </form>
                                            </div>
                                            <p class="mb-0 mt-2"><?php echo e($note->body); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-muted"><?php echo e(__('No notes yet.')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0"><?php echo e(__('Communication Log')); ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="<?php echo e(route('members.communications.store', $member->id)); ?>" class="row g-2 mb-3">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-4">
                                        <label class="form-label"><?php echo e(__('Channel')); ?></label>
                                        <select name="channel" class="form-select" required>
                                            <option value="email"><?php echo e(__('Email')); ?></option>
                                            <option value="sms"><?php echo e(__('SMS')); ?></option>
                                            <option value="call"><?php echo e(__('Call')); ?></option>
                                            <option value="visit"><?php echo e(__('Visit')); ?></option>
                                            <option value="other"><?php echo e(__('Other')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><?php echo e(__('Date')); ?></label>
                                        <input type="date" name="sent_at" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><?php echo e(__('Subject')); ?></label>
                                        <input type="text" name="subject" class="form-control" placeholder="<?php echo e(__('Subject / summary')); ?>">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="body" class="form-control" rows="2" placeholder="<?php echo e(__('Message summary or call notes')); ?>"></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-primary"><?php echo e(__('Log Communication')); ?></button>
                                    </div>
                                </form>

                                <div class="list-group">
                                    <?php $__empty_1 = true; $__currentLoopData = $memberCommunications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $communication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="list-group-item mb-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong class="text-uppercase"><?php echo e(__($communication->channel)); ?></strong>
                                                    <?php if($communication->subject): ?>
                                                        <span class="ms-2"><?php echo e($communication->subject); ?></span>
                                                    <?php endif; ?>
                                                    <div class="small text-muted">
                                                        <?php echo e(optional($communication->sent_at ?? $communication->created_at)->format('M d, Y H:i')); ?>

                                                        <?php if($communication->sender): ?>
                                                            · <?php echo e(__('By')); ?> <?php echo e($communication->sender->name); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($communication->body): ?>
                                                <p class="mb-0 mt-2"><?php echo e($communication->body); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-muted"><?php echo e(__('No communications logged yet.')); ?></p>
                                    <?php endif; ?>
                                </div>

                                <hr class="my-3">
                                <h6><?php echo e(__('Giving Snapshot')); ?></h6>
                                <?php
                                    $totalContributions = $memberContributions->sum('amount');
                                    $lastContribution = $memberContributions->first();
                                ?>
                                <p class="small text-muted mb-1">
                                    <?php echo e(__('Total recorded gifts: :amount', ['amount' => number_format($totalContributions, 2)])); ?>

                                </p>
                                <p class="small text-muted">
                                    <?php echo e(__('Last gift:')); ?>

                                    <?php if($lastContribution): ?>
                                        <?php echo e($lastContribution->received_at?->format('M d, Y')); ?> · <?php echo e(number_format($lastContribution->amount, 2)); ?> <?php echo e($lastContribution->currency); ?>

                                    <?php else: ?>
                                        <?php echo e(__('No gifts recorded')); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Smart Tags -->
            <div class="tab-pane fade" id="smart-tags">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><?php echo e(__('Smart Tags Automation')); ?></h6>
                        <a href="<?php echo e(route('churchly.smart-tags.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-settings"></i> <?php echo e(__('Manage Tags')); ?>

                        </a>
                    </div>
                    <div class="card-body">
                        <?php $matchedTagIds = $member->smartTags->pluck('id')->all(); ?>
                        <div class="mb-4">
                            <h6><?php echo e(__('Current matches')); ?></h6>
                            <?php $__empty_1 = true; $__currentLoopData = $member->smartTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <span class="badge bg-success me-1 mb-1"><?php echo e($tag->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted"><?php echo e(__('No smart tags currently match this profile.')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Tag')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th><?php echo e(__('Last run')); ?></th>
                                        <th><?php echo e(__('Matches')); ?></th>
                                        <th class="text-end"><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $availableSmartTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smartTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e($smartTag->name); ?></strong>
                                                <?php if($smartTag->description): ?>
                                                    <div class="small text-muted"><?php echo e($smartTag->description); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo e($smartTag->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                                    <?php echo e($smartTag->is_active ? __('Active') : __('Disabled')); ?>

                                                </span>
                                                <?php if(in_array($smartTag->id, $matchedTagIds)): ?>
                                                    <span class="badge bg-primary ms-1"><?php echo e(__('Matches this member')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="small text-muted">
                                                <?php echo e($smartTag->last_run_at ? $smartTag->last_run_at->diffForHumans() : __('Never')); ?>

                                            </td>
                                            <td><?php echo e($smartTag->members_count ?? $smartTag->members()->count()); ?></td>
                                            <td class="text-end">
                                                <form method="POST" action="<?php echo e(route('churchly.smart-tags.run', $smartTag->id)); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn btn-sm btn-outline-primary" type="submit"><?php echo e(__('Run')); ?></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Fields -->
            <div class="tab-pane fade" id="custom">
                <div class="card p-3 shadow-sm border-0">
                    <h6><?php echo e(__('Custom Information')); ?></h6>
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $member->customValues ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $custom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-md-6 mb-2">
                                <strong><?php echo e(ucfirst(str_replace('_',' ',$custom->field_key))); ?>:</strong>
                                <span class="text-muted"><?php echo e($custom->field_value); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted"><?php echo e(__('No custom fields added.')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var attachForm = document.querySelector('#household-attach-form');
    if (attachForm) {
        attachForm.addEventListener('submit', function (event) {
            var select = attachForm.querySelector('select[name="household_id"]');
            if (select && !select.value) {
                event.preventDefault();
                alert('<?php echo e(__("Select a household before attaching.")); ?>');
            }
        });
    }
});
</script>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Donations Chart
    new Chart(document.getElementById('donationsChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($donationsMonths, 15, 512) ?>,
            datasets: [{
                label: 'Donations',
                data: <?php echo json_encode($donationsAmounts, 15, 512) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        }
    });
</script>

<!-- Family & Church Trees -->
<script src="https://d3js.org/d3.v7.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const nodesFromServer = <?php echo json_encode($nodes, 15, 512) ?>;
    const linksFromServer = <?php echo json_encode($links, 15, 512) ?>;
    const workspaceName = <?php echo json_encode($workspaceName, 15, 512) ?>;
    const currentMemberId = <?php echo json_encode($member->id, 15, 512) ?>; // ✅ highlight this member

    const nodes = Array.from(new Map(nodesFromServer.map(node => [node.id, node])).values());
    const seenLinks = new Set();
    const links = [];
    linksFromServer.forEach(link => {
        const key = `${link.source}|${link.target}|${link.type}`;
        if (!seenLinks.has(key)) {
            seenLinks.add(key);
            links.push(link);
        }
    });

    const width = document.getElementById("church-tree").clientWidth || window.innerWidth;
    const height = window.innerHeight;


    const colorDept   = d3.scaleOrdinal(d3.schemeTableau10);
    const colorBranch = d3.scaleOrdinal(d3.schemeSet2);

    // ✅ Create SVG with zoom
    const svg = d3.select("#church-tree").append("svg")
        .attr("width", '100%')
        .attr("height", '700px')
        .call(d3.zoom().scaleExtent([0.2, 2]).on("zoom", (event) => {
            container.attr("transform", event.transform);
        }));

    const container = svg.append("g"); // ✅ zoomable group

    const simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(d => d.id).distance(d => {
            if (d.type === "department") return 100;
            if (d.type === "branch") return 150;
            if (d.type === "workspace") return 200;
            return 250;
        }))
        .force("charge", d3.forceManyBody().strength(-350))
        .force("center", d3.forceCenter(width / 2, height / 2));

    // ✅ Links
    const link = container.append("g")
        .attr("stroke-opacity", 0.6)
        .selectAll("line").data(links).enter().append("line")
        .attr("stroke", d => {
            if (d.type === "department") return colorDept(d.source.name);
            if (d.type === "branch") return colorBranch(d.source.name);
            if (d.type === "workspace") return "#6c757d";
            if (d.type === "god") return "#000";
            return "#999";
        })
        .attr("stroke-width", d => d.type === "god" ? 3 : 2)
        .attr("stroke-dasharray", d => d.type === "branch" ? "4,2" : "0");

    // ✅ Node groups
    const node = container.append("g")
        .selectAll("g")
        .data(nodes)
        .enter()
        .append("g")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended)
        );

    // Circle border
    node.append("circle")
        .attr("r", d => d.type === "god" ? 40 :
                       d.type === "workspace" ? 32 :
                       d.type === "branch" ? 28 :
                       d.type === "department" ? 24 : 20)
        .attr("fill", "#fff")
        .attr("stroke", d => {
            if (d.type === "god") return "#0d6efd";
            if (d.type === "workspace") return "#6c757d";
            if (d.type === "branch") return colorBranch(d.name);
            if (d.type === "department") return colorDept(d.name);
            if (d.department) return colorDept(d.department);
            if (d.branch) return colorBranch(d.branch);
            return "#999";
        })
        .attr("stroke-width", 3);

    // Profile photo (for members only)
    node.filter(d => d.type === "member").append("image")
        .attr("xlink:href", d => d.photo || null)
        .attr("x", -15).attr("y", -15)
        .attr("width", 30).attr("height", 30)
        .attr("clip-path", (d, i) => `url(#clip-${i})`);

    // Clip-paths for round images
    svg.append("defs")
        .selectAll("clipPath")
        .data(nodes)
        .enter()
        .append("clipPath")
        .attr("id", (d, i) => `clip-${i}`)
        .append("circle")
        .attr("r", 15).attr("cx", 0).attr("cy", 0);

    // ✅ Labels
    const label = container.append("g")
        .selectAll("text").data(nodes).enter().append("text")
        .text(d => d.name)
        .attr("font-size", d => d.type === "god" ? 16 :
                               d.type === "workspace" ? 14 : 11)
        .attr("font-weight", d => d.id === currentMemberId ? "bold" : "normal")
        .attr("text-anchor", d => d.id === currentMemberId ? "middle" : "start") // center only current member
        .attr("dy", d => d.id === currentMemberId ? 40 : 5) // push label under circle if current
        .attr("dx", d => d.id === currentMemberId ? 0 : 25);

    simulation.on("tick", () => {
        link.attr("x1", d => d.source.x).attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x).attr("y2", d => d.target.y);
        node.attr("transform", d => `translate(${d.x},${d.y})`);
        label.attr("x", d => d.x).attr("y", d => d.y);
    });

    // ✅ Auto zoom & fit
    simulation.on("end", () => {
        const bounds = container.node().getBBox();
        const fullWidth = width, fullHeight = height;
        const dx = bounds.width, dy = bounds.height;
        const x = bounds.x + dx / 2, y = bounds.y + dy / 2;
        const scale = Math.max(0.5, Math.min(2, 0.85 / Math.max(dx / fullWidth, dy / fullHeight)));
        const translate = [fullWidth / 2 - scale * x, fullHeight / 2 - scale * y];

        svg.transition().duration(750).call(
            d3.zoom().transform,
            d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale)
        );
    });

    // ✅ Drag Handlers
    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x; d.fy = d.y;
    }
    function dragged(event, d) { d.fx = event.x; d.fy = event.y; }
    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null; d.fy = null;
    }
});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\show.blade.php ENDPATH**/ ?>