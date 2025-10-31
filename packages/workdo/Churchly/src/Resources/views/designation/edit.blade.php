{!! Form::model($churchdesignation, [
    'route' => ['churchdesignation.update', $churchdesignation->id],
    'method' => 'PUT'
]) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <div class="form-group mb-3">
                    {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => __('Enter designation name')
                    ]) !!}
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('branch_id', __('Branch'), ['class' => 'form-label']) !!}
                    {!! Form::select('branch_id', $branches, null, [
                        'class' => 'form-control select',
                        'required' => true,
                        'placeholder' => __('Select Branch')
                    ]) !!}
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('department_id', __('Department'), ['class' => 'form-label']) !!}
                    {!! Form::select('department_id', $departments, null, [
                        'class' => 'form-control select',
                        'required' => true,
                        'placeholder' => __('Select Department')
                    ]) !!}
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </div>
    </div>
{!! Form::close() !!}
