@extends('layouts.main')

@section('page-title', __('Church Document Types'))
@section('page-breadcrumb', __('Church Document Types'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between mb-2">
            <h5 class="mb-0">{{ __('Church Document Types') }}</h5>
            <a href="{{ route('church.document_types.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> {{ __('Add Document Type') }}
            </a>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Is Required') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentTypes as $doc)
                            <tr>
                                <td>{{ $doc->id }}</td>
                                <td>{{ $doc->name }}</td>
                                <td>{{ $doc->is_required ? __('Yes') : __('No') }}</td>
                                <td>{{ company_date_formate($doc->created_at) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('church.document_types.edit', $doc->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-edit"></i> {{ __('Edit') }}
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['church.document_types.destroy', $doc->id], 'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                <i class="ti ti-trash"></i> {{ __('Delete') }}
                                            </button>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($documentTypes->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No document types found.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $documentTypes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
