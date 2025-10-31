@extends('layouts.empty')
@section('content')
@php $palette = [ 'primary' => $theme->primary_color ?? '#4A6CF7', 'secondary' => $theme->secondary_color ?? '#F9B200' ]; @endphp
<style>
:root{ --primary: {{ $palette['primary'] }}; --secondary: {{ $palette['secondary'] }}; }
body{ font-family: {{ $theme->font_family ?? 'Inter, sans-serif' }}; }
.header{ padding:12px 20px; background:var(--primary); color:#fff; }
.footer{ padding:12px 20px; background:#f5f5f5; color:#666; }
.nav a{ color:#fff; margin-right:16px; text-decoration:none; }
.section{ padding:40px 20px; }
</style>
<div class="header d-flex align-items-center justify-content-between">
  <div class="d-flex align-items-center">
    @if($theme?->logo_path) <img src="{{ asset(Storage::url($theme->logo_path)) }}" height="36" class="me-2"> @endif
    <strong>{{ $page->title ?? 'Site' }}</strong>
  </div>
  <div class="nav">
    @foreach(($menu->items ?? []) as $it)
      <a href="{{ isset($it['slug']) ? url($workspace.'/site/'.ltrim($it['slug'],'/')) : ($it['url'] ?? '#') }}">{{ $it['title'] ?? 'Link' }}</a>
    @endforeach
  </div>
</div>
<div class="content">
  @yield('site')
</div>
<div class="footer text-center small">Powered by Churchly</div>
@endsection