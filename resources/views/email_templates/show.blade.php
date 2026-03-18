@extends('layouts.main')
@section('page-title')
    {{__('Email Templates')}}
@endsection
@section("page-breadcrumb")
    {{__('Email Templates')}}
@endsection
@push('css')
    <link href="{{  asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')  }}" rel="stylesheet">
    <style>
        .email-template-show .card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .email-template-show .card .card-body {
            padding: 18px;
        }

        .email-template-show .section-title {
            margin: 0 0 14px;
            font-size: 13px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #5f7696;
            font-weight: 700;
        }

        .email-template-show .form-group {
            margin-bottom: 14px;
        }

        .email-template-show .col-form-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .04em;
            color: #5f7696 !important;
            margin-bottom: 6px;
        }

        .email-template-show .form-control,
        .email-template-show .note-editor.note-frame {
            border: 1px solid #d8e2ef !important;
            border-radius: 10px;
            box-shadow: none !important;
        }

        .email-template-show .variable-item {
            padding: 8px 10px;
            border: 1px solid #e3ebf7;
            border-radius: 10px;
            margin-bottom: 8px;
            background: #fbfdff;
        }

        .email-template-show .language-sidebar {
            border: 1px solid #d8e2ef !important;
            border-radius: 12px;
            box-shadow: none !important;
            top: 16px;
        }

        .email-template-show .language-sidebar .list-group-item {
            border-color: #e3ebf7 !important;
        }

        .email-template-show .language-sidebar .list-group-item.active {
            background: #ffffff !important;
            color: var(--bs-primary) !important;
            border-color: #d8e2ef !important;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
<div class="row email-template-show">
    <div class="col-md-4 col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="section-title">{{ __('Template Info') }}</h6>
                {{Form::model($emailTemplate, array('route' => array('email_template.update', $emailTemplate->id), 'method' => 'PUT')) }}
                <div class="row">
                    <div class="form-group col-md-12">
                        {{Form::label('name',__('Name'),['class'=>'col-form-label text-dark'])}}
                        {{Form::text('name',null,array('class'=>'form-control font-style','disabled'=>'disabled'))}}
                    </div>
                    <div class="form-group col-md-12">
                        {{Form::label('from',__('From'),['class'=>'col-form-label text-dark'])}}
                        {{Form::text('from',null,array('class'=>'form-control font-style','required'=>'required'))}}
                    </div>
                    {{Form::hidden('lang',$currEmailTempLang->lang,array('class'=>''))}}
                    <div class="col-12 text-end">
                        <input type="submit" value="{{__('Save')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="section-title">{{ __('Template Variables') }}</h6>
                <div class="row text-xs">
                    @php
                        $variables = json_decode($currEmailTempLang->variables);
                    @endphp
                    @if(!empty($variables) > 0)
                    @foreach  ($variables as $key => $var)
                    <div class="col-6 pb-1">
                        <div class="variable-item">
                            <p class="mb-0">{{__($key)}} : <span class="pull-right text-primary">{{ '{'.$var.'}' }}</span></p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
            <div class="row g-3">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="card sticky-top language-sidebar">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @foreach($languages as $key => $lang)
                            <a class="list-group-item list-group-item-action  {{($currEmailTempLang->lang == $key)?'active':''}}" href="{{route('manage.email.language',[$emailTemplate->id,$key])}}">
                                {{Str::ucfirst($lang)}}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    </div>

                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="section-title">{{ __('Email Content') }}</h6>
                            {{Form::model($currEmailTempLang, array('route' => array('store.email.language',$currEmailTempLang->parent_id), 'method' => 'PUT')) }}
                            <div class="row">
                                <div class="form-group col-12">
                                    {{Form::label('subject',__('Subject'),['class'=>'col-form-label text-dark'])}}
                                    {{Form::text('subject',null,array('class'=>'form-control font-style','required'=>'required'))}}
                                </div>
                                <div class="form-group col-12">
                                    {{Form::label('content',__('Email Message'),['class'=>'col-form-label text-dark'])}}
                                    {{Form::textarea('content',$currEmailTempLang->content,array('class'=>'summernote','id'=>'content','required'=>'required'))}}
                                </div>

                                <div class="col-md-12 text-end mb-0">
                                    {{Form::hidden('lang',null)}}
                                    <input type="submit" value="{{__('Save')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection
@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
@endpush
