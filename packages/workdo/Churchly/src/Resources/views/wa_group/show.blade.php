@extends('layouts.main')

@section('page-title')
    {{ __('Group Details') }}
@endsection

@section('page-breadcrumb')
    {{ __('WA Groups') }}
@endsection

@section('page-action')
    <a href="{{ route('wa_group.index') }}" class="btn btn-sm btn-danger">
        <i class="ti ti-arrow-left"></i> {{ __('Back') }}
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Left Sidebar --}}
    <div class="col-sm-2">
        @include('churchly::layouts.churchly_setup')
    </div>

    {{-- Main Table --}}
    <div class="col-sm-6">
        {{-- Main Group Info --}}
        <div class="card p-4 mb-4">
            <h4 class="mb-2"><i class="ti ti-brand-whatsapp text-success"></i> {{ $group->name }}</h4>
            <p class="text-muted mb-2">
                <strong>{{ __('Group ID:') }}</strong> {{ $group->group_id }}
            </p>
            <p class="small text-muted">
                {{ __('This is the unique identifier synced from Zender. It is required for sending automated WhatsApp messages to this group.') }}
            </p>

            {{-- Branch Assignments --}}
            <h6 class="mt-4">{{ __('Assigned Branches') }}</h6>
            @if($group->branches->count())
                <ul class="list-unstyled ps-3">
                    @foreach($group->branches as $branch)
                        <li><i class="ti ti-building text-primary"></i> {{ $branch->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted small">{{ __('No branches have been linked to this group.') }}</p>
            @endif

            {{-- Department Assignments --}}
            <h6 class="mt-4">{{ __('Assigned Departments') }}</h6>
            @if($group->departments->count())
                <ul class="list-unstyled ps-3">
                    @foreach($group->departments as $dept)
                        <li><i class="ti ti-users text-info"></i> {{ $dept->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted small">{{ __('No departments have been linked to this group.') }}</p>
            @endif

            {{-- Designation Assignments --}}
            <h6 class="mt-4">{{ __('Assigned Designations') }}</h6>
            @if($group->designations->count())
                <ul class="list-unstyled ps-3">
                    @foreach($group->designations as $des)
                        <li><i class="ti ti-id-badge text-warning"></i> {{ $des->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted small">{{ __('No designations have been linked to this group.') }}</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        {{-- Documentation / Instructions --}}
        <div class="card p-4">
            <h6 class="mb-3"><i class="ti ti-info-circle text-primary"></i> {{ __('How WhatsApp Groups Work') }}</h6>
            <p class="text-muted small mb-3">
                {{ __('WhatsApp groups allow you to organize communication inside your church system. They are synced from Zender and can be assigned to branches, departments, and designations.') }}
            </p>

            <ul class="small text-muted ps-3 mb-3">
                <li><strong>{{ __('Branch Assignment') }}:</strong> {{ __('Link a group to an entire branch (e.g., Main Branch, City Branch). All members of that branch can be reached.') }}</li>
                <li><strong>{{ __('Department Assignment') }}:</strong> {{ __('Narrow the group to specific departments such as Choir, Ushering, or Youth Ministry.') }}</li>
                <li><strong>{{ __('Designation Assignment') }}:</strong> {{ __('Target roles within departments, such as Head Usher or Choir Leader.') }}</li>
            </ul>

            <p class="small text-muted mb-3">
                {{ __('💡 If you assign a group without selecting a branch, department, or designation, it becomes a global group visible across the entire workspace.') }}
            </p>

            <hr>

            <h6 class="mb-2">{{ __('Best Practices') }}</h6>
            <ul class="small text-muted ps-3">
                <li>{{ __('Keep group names clear (e.g., "Choir Leaders - Main Branch").') }}</li>
                <li>{{ __('Avoid assigning the same group to too many entities to prevent confusion.') }}</li>
                <li>{{ __('Always test group assignment by sending a test WhatsApp message.') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
