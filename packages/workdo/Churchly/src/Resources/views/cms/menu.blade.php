@extends('layouts.main')
@section('page-title', __('Website Menu'))
@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('cms.pages') }}">{{ __('Website CMS') }}</a></li>
<li class="breadcrumb-item active">{{ __('Menu') }}</li>
@endsection
@section('content')
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('cms.menu.save') }}" id="menuForm">@csrf
<div class="mb-3"><label class="form-label">{{ __('Menu Title') }}</label><input type="text" name="title" class="form-control" value="{{ $menu->title }}"></div>
<table class="table align-middle" id="menuTable"><thead><tr><th>{{ __('Title') }}</th><th>{{ __('Slug/URL') }}</th><th></th></tr></thead><tbody>
@php $items = $menu->items ?? []; @endphp
@foreach($items as $i => $it)
<tr>
  <td><input type="text" class="form-control" value="{{ $it['title'] ?? '' }}" data-field="title"></td>
  <td><input type="text" class="form-control" value="{{ $it['slug'] ?? ($it['url'] ?? '') }}" data-field="link"></td>
  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>
</tr>
@endforeach
</tbody></table>
<button type="button" id="addItem" class="btn btn-outline-secondary btn-sm"><i class="ti ti-plus"></i> {{ __('Add Item') }}</button>
<input type="hidden" name="items" id="itemsJson">
<div class="text-end mt-3"><button class="btn btn-primary">{{ __('Save Menu') }}</button></div>
</form>
</div></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.querySelector('#menuTable tbody');
  Sortable.create(tbody,{ animation:150 });
  document.getElementById('addItem').addEventListener('click', function(){
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><input type="text" class="form-control" data-field="title" placeholder="Home"></td>
                  <td><input type="text" class="form-control" data-field="link" placeholder="/ or about"></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>`;
    tbody.appendChild(tr);
  });
  tbody.addEventListener('click', function(e){ if(e.target.closest('.remove-row')) e.target.closest('tr').remove(); });
  document.getElementById('menuForm').addEventListener('submit', function(){
    const items=[]; tbody.querySelectorAll('tr').forEach(tr=>{ items.push({ title: tr.querySelector('[data-field="title"]').value, slug: tr.querySelector('[data-field="link"]').value }); });
    document.getElementById('itemsJson').value = JSON.stringify(items);
  });
});
</script>
@endpush