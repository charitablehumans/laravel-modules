@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.track'))
@section('content_header', trans('cms::cms.track'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.track')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border"></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">@lang('cms::cms.waybill_number')</th>
                                    <th class="text-left">@lang('cms::cms.service_code')</th>
                                    <th class="text-left">@lang('cms::cms.waybill_date')</th>
                                    <th class="text-left">@lang('cms::cms.origin')</th>
                                    <th class="text-left">@lang('cms::cms.destination')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $waybill['summary']['waybill_number'] }}</td>
                                    <td>{{ $waybill['summary']['service_code'] }}</td>
                                    <td>{{ $waybill['summary']['waybill_date'] }}</td>
                                    <td>{{ $waybill['summary']['origin'] }}</td>
                                    <td>{{ $waybill['summary']['destination'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left" width="50%">@lang('cms::cms.shipper_name')</th>
                                    <th class="text-left" width="50%">@lang('cms::cms.receiver_name')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $waybill['summary']['shipper_name'] }}</td>
                                    <td>{{ $waybill['summary']['receiver_name'] }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $waybill['summary']['origin'] }}</td>
                                    <td>{{ $waybill['summary']['destination'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left" colspan="2">@lang('cms::cms.manifest')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (is_array($waybill['manifest']))
                                    @foreach ($waybill['manifest'] as $manifest)
                                        <tr>
                                            <td>{{ $manifest['manifest_date'].' '.$manifest['manifest_time'] }}</td>
                                            <td>{{ $manifest['manifest_description'].' ['.$manifest['city_name'].']' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
