@extends('cms::backend/layouts/media_iframe')

@section('title', trans('cms::cms.menus'))
@section('content_header', 'RPX')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">RPX</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-body table-responsive">
            @if($has_record == true)
                <div class="col-md-5">
                    <h3>Tracking AWB</h3>
                    <br>
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr style="background-color: black; color: white;">
                                <th colspan="2">Detailed Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="right">AWB Number:</td>
                                <td align="left">{{ $awb_number }}</td>
                            </tr>
                            <tr>
                                <td align="right">Delivery To:</td>
                                <td align="left">{{ $details['DELIVERY_TO'] }}</td>
                            </tr>
                            <tr>
                                <td align="right">Received by:</td>
                                <td align="left">{{ $details['RECEIVED_BY'].' - '.$details['LOC_DESC'] }}</td>
                            </tr>
                            <tr>
                                <td align="right">Signature:</td>
                                <td align="left">{{ $details['IMAGE_SIGNATURE'] }}</td>
                            </tr>
                            <tr>
                                <td align="right">Destination:</td>
                                <td align="left">{{ $details['DELIVERY_LOC'] }}</td>
                            </tr>
                            <tr>
                                <td align="right">Delivery Date:</td>
                                <td align="left">{{ $details['DELIVERY_DATE'] }}</td>
                            </tr>
                            <tr>
                                <td align="right">Received Time:</td>
                                <td align="left">{{ $details['DELIVERY_TIME'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-7">
                    <h3>Activity</h3>
                    <br>
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr style="background-color: black; color: white;">
                                <th>Tracking Description</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($activities as $activity)
                                @if($no++ >= 2)
                                    <tr>
                                        <td align="left">{{ $activity['TRACKING_DESC'] }}</td>
                                        <td align="left">{{ $activity['LOCATION'] }}</td>
                                        <td align="left">{{ $activity['TRACKING_DATE'] }}</td>
                                        <td align="center">{{ $activity['TRACKING_TIME'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-md-12" align="center">
                    No data found.
                </div>
            @endif
        </div>
    </div>
@endsection
