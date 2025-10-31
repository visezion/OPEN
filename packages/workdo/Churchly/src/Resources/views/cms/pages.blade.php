@extends('layouts.main')
@section('page-title', __('Website Pages'))
@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active">{{ __('Website Pages') }}</li>
@endsection
@section('page-action')
  <a href="{{ route('cms.pages.create') }}" class="btn btn-sm btn-primary"><i class="ti ti-plus"></i> {{ __('New Page') }}</a>
@endsection
@section('content')
<div class="card"><div class="card-body">
<table class="table align-middle"><thead><tr>
<th>{{ __('Title') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Home') }}</th><th>{{ __('Published') }}</th><th>{{ __('Order') }}</th><th></th>
</tr></thead><tbody>
@forelse($pages as $p)
<tr>
  <td>{{ $p->title }}</td>
  <td>{{ $p->slug }}</td>
  <td>{{ $p->is_home ? 'Yes':'No' }}</td>
  <td>{{ $p->is_published ? 'Yes':'No' }}</td>
  <td>{{ $p->sort_order }}</td>
  <td>
    <a href="{{ route('cms.pages.edit',$p->id) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
    <form method="POST" action="{{ route('cms.pages.delete',$p->id) }}" style="display:inline">@csrf @method('DELETE')
      <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete page?')">{{ __('Delete') }}</button>
    </form>
  </td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted">{{ __('No pages yet') }}</td></tr>
@endforelse
</tbody></table>
</div></div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const tbody = document.querySelector('table tbody');
  if(!tbody) return;
  Sortable.create(tbody,{ animation:150 });
  const saveBtn = document.createElement('button');
  saveBtn.className='btn btn-sm btn-outline-secondary';
  saveBtn.innerText='Save Order';
  saveBtn.addEventListener('click', function(){
    const ids=[]; tbody.querySelectorAll('tr').forEach(tr=>{ const id = tr.querySelector('a[href*="/edit"]')?.getAttribute('href')?.match(/\/(\d+)\/edit/); if(id){ ids.push(id[1]); } });
    const form=document.createElement('form'); form.method='POST'; form.action='{{ route('cms.pages.sort') }}';
    form.innerHTML='@csrf'+ids.map(i=>`<input type="hidden" name="order[]" value="${i}">`).join('');
    document.body.appendChild(form); form.submit();
  });
  document.querySelector('.card-body')?.prepend(saveBtn);
});
</script>
@endpush