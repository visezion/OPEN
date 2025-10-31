@extends('churchly::site.layout')
@section('site')
  @foreach(($page->sections ?? []) as $s)
    <div class="section">
      <h3>{{ $s->title }}</h3>
      <pre class="bg-light p-2 rounded">{{ json_encode($s->content) }}</pre>
    </div>
  @endforeach
@endsection