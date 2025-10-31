@extends('churchly::site.layout')
@section('site')
  @if($page)
    @foreach(($page->sections ?? []) as $s)
      <div class="section">
        <h3>{{ $s->title }}</h3>
        <pre class="bg-light p-2 rounded">{{ json_encode($s->content) }}</pre>
      </div>
    @endforeach
  @else
    <div class="section text-center text-muted">No home page yet.</div>
  @endif
@endsection