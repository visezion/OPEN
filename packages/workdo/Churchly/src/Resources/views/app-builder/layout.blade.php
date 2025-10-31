@extends('layouts.main')

@section('page-title', __('Home Layout'))

@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('app-builder.index') }}">{{ __('App Builder') }}</a></li>
<li class="breadcrumb-item active">{{ __('Home Layout') }}</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('app-builder.saveLayout') }}">
            @csrf
            <input type="hidden" name="screen_key" value="home">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Screen Title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ $layout->title }}" placeholder="Home">
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('app-builder.index') }}" class="btn btn-light mt-4">{{ __('Back to Builder') }}</a>
                    <button class="btn btn-primary mt-4" type="submit">{{ __('Save Layout') }}</button>
                </div>
            </div>

            <div class="d-flex gap-2 mb-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-plus"></i> {{ __('Add Widget') }}
                    </button>
                    <ul class="dropdown-menu" id="widgetLibrary">
                        <li><a class="dropdown-item add-widget" data-type="banner_carousel" href="#">Banner Carousel</a></li>
                        <li><a class="dropdown-item add-widget" data-type="quick_links" href="#">Quick Links</a></li>
                        <li><a class="dropdown-item add-widget" data-type="latest_sermons" href="#">Latest Sermons</a></li>
                        <li><a class="dropdown-item add-widget" data-type="upcoming_events" href="#">Upcoming Events</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item add-widget" data-type="custom_html" href="#">Custom HTML</a></li>
                    </ul>
                </div>
                <span class="small text-muted align-self-center">{{ __('Drag rows to reorder. No JSON needed — fields per type.') }}</span>
            </div>

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width:18%">{{ __('Type') }}</th>
                        <th style="width:22%">{{ __('Title') }}</th>
                        <th>{{ __('Settings') }}</th>
                        <th style="width:90px" class="text-center">{{ __('Active') }}</th>
                        <th style="width:40px"></th>
                    </tr>
                </thead>
                <tbody id="widgetsTable">
                    @php $types = ['banner_carousel','quick_links','latest_sermons','upcoming_events','custom_html']; @endphp
                    @forelse($widgets as $i => $w)
                    @php $c = is_array($w->settings) ? $w->settings : (json_decode($w->settings, true) ?: []); @endphp
                    <tr class="sortable-item">
                        <td>
                            <select name="widgets[{{ $i }}][type]" class="form-select widget-type">
                                @foreach($types as $t)
                                    <option value="{{ $t }}" {{ $w->type==$t ? 'selected':'' }}>{{ str_replace('_',' ',ucfirst($t)) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="widgets[{{ $i }}][title]" class="form-control" value="{{ $w->title }}" placeholder="{{ __('Optional title') }}">
                        </td>
                        <td class="settings-cell">
                            @include('churchly::app-builder.widget_fields', ['idx'=>$i,'type'=>$w->type,'settings'=>$c])
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="widgets[{{ $i }}][active]" value="1" {{ $w->active ? 'checked' : '' }}>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            <div class="text-end mt-3">
                <button class="btn btn-primary" type="submit">{{ __('Save Layout') }}</button>
            </div>
            <div class="row mt-4">
                <div class="col-lg-8">
                    <!-- keep form in this column -->
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header"><h6 class="mb-0">{{ __('Live Preview') }}</h6></div>
                        <div class="card-body text-center">
                            <div id="layoutPreview" class="phone-frame mx-auto">
                                <div class="phone-screen d-flex flex-column">
                                    <div class="phone-header text-white p-2 fw-bold" id="layoutPreviewHeader">{{ $layout->title ?? 'Home' }}</div>
                                    <div id="layoutPreviewBody" class="flex-grow-1 overflow-auto p-2" style="background:#3f5be7;">
                                        <div class="text-white-50 small">{{ __('Widgets will render here as you edit') }}</div>
                                    </div>
                                    <div class="phone-nav d-flex justify-content-around p-2"><i class="ti ti-dots text-white-50"></i></div>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">{{ __('Updates live as you change fields and types') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  Sortable.create(document.getElementById('widgetsTable'), { animation: 150, onSort: renderPreview });

  const lib = document.getElementById('widgetLibrary');
  lib?.addEventListener('click', function(e){
    const a = e.target.closest('.add-widget'); if(!a) return; e.preventDefault();
    addWidgetRow(a.dataset.type || 'banner_carousel');
    renderPreview();
  });

  document.getElementById('widgetsTable').addEventListener('click', function(e){
    if (e.target.closest('.remove-row')) {
      e.target.closest('tr').remove();
      renderPreview();
    }
  });

  document.getElementById('widgetsTable').addEventListener('change', function(e){
    const sel = e.target.closest('.widget-type');
    if(sel){
      const tr = sel.closest('tr');
      const tbody = document.getElementById('widgetsTable');
      const idx = Array.from(tbody.rows).indexOf(tr);
      const cell = tr.querySelector('.settings-cell');
      cell.innerHTML = renderFields(sel.value, idx);
      renderPreview();
    }
  });

  function addWidgetRow(type){
    const tbody = document.getElementById('widgetsTable');
    const idx = tbody.children.length;
    const tr = document.createElement('tr');
    tr.className = 'sortable-item';
    tr.innerHTML = `
      <td>
        <select name="widgets[${idx}][type]" class="form-select widget-type">
          ${['banner_carousel','quick_links','latest_sermons','upcoming_events','custom_html'].map(opt=>`<option value="${opt}" ${opt===type?'selected':''}>${opt.replace('_',' ')}</option>`).join('')}
        </select>
      </td>
      <td><input type="text" name="widgets[${idx}][title]" class="form-control" placeholder="${'{{ __('Optional title') }}'}"></td>
      <td class="settings-cell">${renderFields(type, idx)}</td>
      <td class="text-center"><input type="checkbox" name="widgets[${idx}][active]" value="1" checked></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">&times;</button></td>`;
    tbody.appendChild(tr);
  }

  function renderFields(type, idx){
    switch(type){
      case 'banner_carousel':
        return `
          <div class="row g-2">
            <div class="col-md-8"><textarea class="form-control" rows="2" name="widgets[${idx}][images_text]" placeholder="One image URL per line"></textarea></div>
            <div class="col-md-2 form-check form-switch"><input class="form-check-input" type="checkbox" name="widgets[${idx}][autoplay]"> Autoplay</div>
            <div class="col-md-2"><input type="number" class="form-control" name="widgets[${idx}][interval]" placeholder="3000"></div>
          </div>`;
      case 'quick_links':
        return `
          <div class="row g-2">
            <div class="col-md-12"><textarea class="form-control" rows="2" name="widgets[${idx}][links_text]" placeholder="Title|ti ti-icon|target per line"></textarea></div>
          </div>`;
      case 'latest_sermons':
        return `
          <div class="row g-2">
            <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[${idx}][limit]" placeholder="Limit"></div>
            <div class="col-md-9"><input class="form-control" name="widgets[${idx}][source]" placeholder="Playlist/Channel ID (optional)"></div>
          </div>`;
      case 'upcoming_events':
        return `
          <div class="row g-2">
            <div class="col-md-3"><input type="number" min="1" class="form-control" name="widgets[${idx}][limit]" placeholder="Limit"></div>
            <div class="col-md-3 form-check form-switch"><input class="form-check-input" type="checkbox" name="widgets[${idx}][show_past]"> Show past</div>
          </div>`;
      case 'custom_html':
      default:
        return `<textarea class="form-control" rows="3" name="widgets[${idx}][html]" placeholder="&lt;div&gt;...&lt;/div&gt;"></textarea>`;
    }
  }

  function renderPreview(){
    const body = document.getElementById('layoutPreviewBody');
    const header = document.getElementById('layoutPreviewHeader');
    const titleInput = document.querySelector('input[name=title]');
    if (header && titleInput) header.innerText = titleInput.value || 'Home';
    const rows = document.querySelectorAll('#widgetsTable tr');
    let html = '';
    rows.forEach((row, i)=>{
      const type = row.querySelector('.widget-type')?.value || 'custom_html';
      const title = row.querySelector(`input[name="widgets[${i}][title]"]`)?.value || '';
      const active = row.querySelector(`input[name="widgets[${i}][active]"]`)?.checked;
      if (!active) return;
      html += previewBlock(type, title, i, row);
    });
    body.innerHTML = html || '<div class="text-white-50 small">No active widgets</div>';
  }

  function previewBlock(type, title, idx, row){
    const cardStart = `<div class="card bg-white mb-2"><div class="card-body py-2 px-3">`;
    const cardEnd = `</div></div>`;
    switch(type){
      case 'banner_carousel':
        return `${cardStart}<div class="fw-semibold">${title||'Banner Carousel'}</div><div class="d-flex gap-2 mt-1">${[1,2,3].map(()=>'<div style=\"width:60px;height:36px;background:#e9eefc;border-radius:6px\"></div>').join('')}</div>${cardEnd}`;
      case 'quick_links':
        return `${cardStart}<div class="fw-semibold">${title||'Quick Links'}</div><div class="d-flex justify-content-between text-center mt-1">${[1,2,3,4].map(()=>'<div class=\"small\"><i class=\"ti ti-circle\"></i><br><small>Link</small></div>').join('')}</div>${cardEnd}`;
      case 'latest_sermons':
        return `${cardStart}<div class="fw-semibold">${title||'Latest Sermons'}</div><div class="mt-1 text-muted small">Video list preview…</div>${cardEnd}`;
      case 'upcoming_events':
        return `${cardStart}<div class="fw-semibold">${title||'Upcoming Events'}</div><div class="mt-1 text-muted small">Events list preview…</div>${cardEnd}`;
      default:
        const htmlText = row.querySelector(`textarea[name="widgets[${idx}][html]"]`)?.value || '';
        return `${cardStart}${title?`<div class=\"fw-semibold\">${title}</div>`:''}<div class="mt-1 small text-muted">Custom HTML</div>${cardEnd}`;
    }
  }

  // initial render
  renderPreview();
});
</script>
@endpush
