<form method="POST" action="{{ route('app-builder.saveMenu') }}">
    @csrf
    <div id="menuBuilderContainer">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Feature') }}</th>
                    <th>{{ __('Icon') }}</th>
                    <th>{{ __('Visible') }}</th>
                </tr>
            </thead>
            <tbody id="sortableMenu">
                @foreach($menus as $item)
                    <tr class="sortable-item">
                        <td>
                            <input type="text" class="form-control" name="menu[{{ $loop->index }}][title]" value="{{ $item->title }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="menu[{{ $loop->index }}][feature_key]" value="{{ $item->feature_key }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="menu[{{ $loop->index }}][icon_name]" value="{{ $item->icon_name }}">
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="menu[{{ $loop->index }}][visible]" value="1" {{ $item->visible ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-outline-secondary btn-sm" id="addRowBtn">
            <i class="ti ti-plus"></i> {{ __('Add Item') }}
        </button>
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Save Menu Layout') }}</button>
    </div>
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Sortable.create(document.getElementById('sortableMenu'), { animation: 150 });

    document.getElementById('addRowBtn').addEventListener('click', function(){
        const tbody = document.getElementById('sortableMenu');
        const index = tbody.children.length;
        tbody.insertAdjacentHTML('beforeend', `
            <tr class="sortable-item">
                <td><input type="text" name="menu[${index}][title]" class="form-control" placeholder="Title"></td>
                <td><input type="text" name="menu[${index}][feature_key]" class="form-control" placeholder="Feature"></td>
                <td><input type="text" name="menu[${index}][icon_name]" class="form-control" placeholder="Icon"></td>
                <td><input class="form-check-input" type="checkbox" name="menu[${index}][visible]" value="1" checked></td>
            </tr>
        `);
    });
});
</script>
@endpush
