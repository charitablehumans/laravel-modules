@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.create'))
@section('content_header', trans('cms::cms.create'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>Doku</li>
        <li class="active">@lang('cms::cms.create')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.doku.store') }}" method="post">
        {{ csrf_field() }}
        <div class="box">
            <div class="box-header hidden with-border"></div>
            <div class="box-body">
                <div class="form-group">
                    <label>Transaction Id</label>
                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="id" required>
                        <option></option>
                        @foreach ($transactions as $transaction)
                            <option value="{{ $transaction->id }}">{{ $transaction->id }}</option>
                        @endforeach
                    </select>
                    <i class="text-danger">{{ $errors->first('id') }}</i>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </form>
@endsection
