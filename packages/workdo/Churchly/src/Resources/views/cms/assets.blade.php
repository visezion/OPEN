@extends('layouts.main')
@section('page-title', __('Website Assets'))
@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('cms.pages') }}">{{ __('Website CMS') }}</a></li>
<li class="breadcrumb-item active">{{ __('Assets') }}</li>
@endsection
@section('content')
<div class="card"><div class="card-body">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  @if(session('uploaded'))<div class="alert alert-info small">{{ __('Uploaded URL:') }} <code>{{ session('uploaded') }}</code></div>@endif
  <form method="POST" action="{{ route('cms.assets.upload') }}" enctype="multipart/form-data">@csrf
    <div class="row align-items-end">
      <div class="col-md-6 mb-3"><label class="form-label">{{ __('Upload File') }}</label><input type="file" name="file" class="form-control" required></div>
      <div class="col-md-3 mb-3"><button class="btn btn-primary">{{ __('Upload') }}</button></div>
    </div>
  </form>
  <hr>
  <div class="row">
    @forelse($files as $f)
      <div class="col-md-3 mb-3">
        <div class="border rounded p-2 text-center">
          <img src="{{ $f['url'] }}" class="img-fluid" style="max-height:120px;object-fit:contain">
          <div class="small mt-2"><code>{{ $f['url'] }}</code></div>
        </div>
      </div>
    @empty
      <div class="col-12 text-muted small">{{ __('No assets yet') }}</div>
    @endforelse
  </div>
</div></div>
@endsection