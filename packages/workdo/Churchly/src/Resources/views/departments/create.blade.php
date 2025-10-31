
                {{ Form::open(['route' => 'churchly.departments.store', 'method' => 'POST', 'class' => 'needs-validation', 'novalidate']) }}
                <div class="modal-body">        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            {{ Form::label('name', __('Department Name'), ['class' => 'form-label']) }} <x-required />
                            {{ Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter Department Name')]) }}
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('branch_id', __('Branch'), ['class' => 'form-label']) }} <x-required />
                            {{ Form::select('branch_id', $branches, null, ['class' => 'form-control select', 'required', 'placeholder' => __('Select Branch')]) }}
                         </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="text-end">
                    <a href="{{ route('churchly.departments.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Create Department') }}</button>
              
            </div>
        </div>

                {{ Form::close() }}
            