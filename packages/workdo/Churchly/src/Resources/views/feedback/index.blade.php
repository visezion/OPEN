@extends('layouts.main')

@section('page-title')
    {{ __('Feedback Management ') }}
@endsection

@section('page-breadcrumb')
    {{ __('Feedback Dashboard') }}
@endsection
@section('page-action')
        
    </style>
    <span>
          
         <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <a href="{{ route('feedback.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> 
        </a>
   
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- Filters -->
            

            <!-- Feedback Table -->
            <div class="card">
                <div class="card-body table-responsive"> 
                    <form method="GET" action="{{ route('feedback.index') }}" class="row mb-3 g-2 align-items-end">
                       <div class="col-md-2 d-flex align-items-center">
                            <label class="form-label me-2 mb-0" for="per_page">{{ __('Pages:') }}</label>
                            <select name="per_page" id="per_page" class="form-control form-control-sm w-auto me-2">
                                @foreach ([10, 15, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 15) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-label mb-0">{{ __('entries') }}</span>
                        </div>

                        <div class="col-md-2">
                            <select name="type" class="form-control form-control-sm">
                                <option value="">{{ __('All Types') }}</option>
                                <option value="internal" {{ request('type') == 'internal' ? 'selected' : '' }}>{{ __('Internal') }}</option>
                                <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>{{ __('Public') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control form-control-sm">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>{{ __('Reviewed') }}</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-control form-control-sm">
                                <option value="">{{ __('All Categories') }}</option>
                                <option value="suggestion" {{ request('category') == 'suggestion' ? 'selected' : '' }}>{{ __('Suggestion') }}</option>
                                <option value="complaint" {{ request('category') == 'complaint' ? 'selected' : '' }}>{{ __('Complaint') }}</option>
                                <option value="praise" {{ request('category') == 'praise' ? 'selected' : '' }}>{{ __('Praise') }}</option>
                                <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                        </div>
                         <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search with (title or message)" value="{{ request('search') }}">
                        </div>
                         
                        <div class="col-md-1">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="ti ti-filter"></i>
                            </button>
                        </div>
                    </form>

                    <table class="table table-bordered" id="feedback-table">
                        <thead>
                            <tr>
                                <th>{{ __('Depertment') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Submitted By') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $index => $item)
                                <tr>
                                   <td>{{ $item->department->name ?? 'No Department' }}</td>
                                    <td>{{ $item->title ?? 'No Title' }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($item->type) }}</span></td>
                                    <td><span class="badge bg-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'reviewed' ? 'primary' : 'success') }}">{{ ucfirst($item->status) }}</span></td>
                                    <td>{{ $item->is_anonymous ? 'Anonymous' : ($item->name ?? 'N/A') }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td>
                                         @permission('feedback review')
                                            <a href="{{ route('feedback.review', \Illuminate\Support\Facades\Crypt::encrypt( $item->id)) }}" class="btn btn-sm btn-outline-primary" title="Review"><i class="ti ti-file"></i></a>
                                        @endpermission
                                        <a href="{{ route('feedback.show', \Illuminate\Support\Facades\Crypt::encrypt( $item->id)) }}" class="btn btn-sm btn-outline-info" title="Review"><i class="ti ti-eye"></i></a>
                                        @permission('feedback edit')
                                            <a href="{{ route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt( $item->id)) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ti ti-edit"></i></a>
                                        @endpermission
                                       @permission('feedback delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['feedback.destroy', Crypt::encrypt($item->id)], 'class' => 'delete-feedback-form', 'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-sm btn-outline-danger show_confirm" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    @endpermission

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
              
                    @if($feedbacks->hasPages())
                       <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap small text-muted">
                        <div class="mb-2 mb-md-0">
                            Showing <strong>{{ $feedbacks->firstItem() }}</strong> to <strong>{{ $feedbacks->lastItem() }}</strong> of <strong>{{ $feedbacks->total() }}</strong> results
                        </div>
                        <div> 
                           {{ $feedbacks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
