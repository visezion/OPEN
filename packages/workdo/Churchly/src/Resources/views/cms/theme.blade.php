@extends('layouts.main')
@section('page-title', __('Website Theme'))
@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('cms.pages') }}">{{ __('Website CMS') }}</a></li>
<li class="breadcrumb-item active">{{ __('Theme') }}</li>
@endsection
@section('content')
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('cms.theme.save') }}" enctype="multipart/form-data">@csrf
<div class="row">
  <div class="col-md-3 mb-3"><label class="form-label">{{ __('Primary Color') }}</label><input type="color" name="primary_color" class="form-control form-control-color" value="{{ $theme->primary_color ?? '#4A6CF7' }}"></div>
  <div class="col-md-3 mb-3"><label class="form-label">{{ __('Secondary Color') }}</label><input type="color" name="secondary_color" class="form-control form-control-color" value="{{ $theme->secondary_color ?? '#F9B200' }}"></div>
  <div class="col-md-6 mb-3"><label class="form-label">{{ __('Font Family') }}</label><input type="text" name="font_family" class="form-control" value="{{ $theme->font_family }}"></div>
  <div class="col-md-6 mb-3"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo_path" class="form-control">@if($theme->logo_path)<img src="{{ asset(Storage::url($theme->logo_path)) }}" class="img-thumbnail mt-2" width="120">@endif</div>
  <div class="col-md-6 mb-3"><label class="form-label">{{ __('Favicon') }}</label><input type="file" name="favicon_path" class="form-control"></div>
  <div class="col-md-12 mb-3"><label class="form-label">{{ __('Custom CSS') }}</label><textarea name="custom_css" class="form-control" rows="4">{{ $theme->custom_css }}</textarea></div>
  <div class="col-md-12 text-end"><button class="btn btn-primary">{{ __('Save Theme') }}</button></div>
</div>
</form>
</div></div>
@endsection