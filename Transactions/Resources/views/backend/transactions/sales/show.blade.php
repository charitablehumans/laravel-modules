@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.sales'))
@section('content_header', trans('cms::cms.sales'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('backend.transactions.sales.index', request()->query()) }}">@lang('cms::cms.sales')</a>
        </li>
        <li class="active">{{ $transaction->id }}</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.transactions.sales.update', $transaction->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('cms::cms.'.$transaction->status)</h3>
                        @if (in_array($transaction->status, ['new']))
                            <a class="btn btn-primary btn-sm" href="{{ route('backend.transactions.sales.process', $transaction->id) }}">@lang('cms::cms.process')</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('backend.transactions.sales.reject', $transaction->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_reject_this')?')">@lang('cms::cms.reject')</a>
                        @endif
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <label>@lang('validation.attributes.number')</label><br />
                            {{ $transaction->id }}
                            <hr />
                        </div>
                        <div class="form-group">
                            <label>@lang('validation.attributes.address')</label><br />
                            {{ $transaction->transactionShippingAddress->name.', '.$transaction->transactionShippingAddress->phone_number }}<br />
                            {{ $transaction->transactionShippingAddress->address }}<br />
                            {{ $transaction->transactionShippingAddress->district_id.', '.$transaction->transactionShippingAddress->regency->name.', '.$transaction->transactionShippingAddress->province->name.', '.$transaction->transactionShippingAddress->postal_code }}
                            <hr />
                        </div>
                        <div class="form-inline">
                            <label>@lang('cms::cms.transaction_shipment')</label><br />
                            {{ $transaction->transactionShipment->name.', '.$transaction->transactionShipment->service.' ('.$transaction->transactionShipment->description.')' }}
                            @if (in_array($transaction->status, ['processed', 'sent']))
                                <input class="form-control input-sm" name="receipt_number" placeholder="@lang('validation.attributes.receipt_number')" required type="text" value="{{ $transaction->receipt_number }}" />
                                <input class="btn btn-success btn-sm" name="send" type="submit" value="@lang('cms::cms.save')" />
                            @endif
                            @if (in_array($transaction->status, ['sent']) && $transaction->receipt_number)
                                @if ($transaction->transactionShipment->code == $transaction->transactionShipment::$codeRpx)
                                    <a data-fancybox data-type="iframe" href="{{ route('frontend.rpx.sales.tracking.show', $transaction->receipt_number) }}" class="btn btn-primary btn-sm">Tracking AWB</a>
                                @else
                                    <a data-fancybox data-type="iframe" href="{{ route('rajaongkir.backend.rajaongkir.tracking', [$transaction->transactionShipment->code, $transaction->receipt_number, 'layout' => 'media_iframe']) }}" class="btn btn-primary btn-sm">@lang('cms::cms.track')</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <a href="mailto:{{ $transaction->receiver->email }}">{{ $transaction->receiver->email }}</a>,
                        {{ $transaction->receiver->name }},
                        {{ $transaction->receiver->phone_number }}
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('cms::cms.transaction_details')</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('cms::cms.product_name')</th>
                                    <th>@lang('validation.attributes.price')</th>
                                    <th>@lang('validation.attributes.quantity')</th>
                                    <th>@lang('cms::cms.subtotal')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->transactionDetails as $i => $transactionDetail)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <div class="media">
                                                <div class="media-left">
                                                    <a data-fancybox="group" href="{{ \Storage::url($transactionDetail->product->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true)) }}" target="_blank">
                                                        <img class="contain media-object" src="{{ \Storage::url($transactionDetail->product->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true)) }}" style="height: 60px; width: 60px;" />
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">{{ $transactionDetail->product->title }}</h4>
                                                    <p>@lang('validation.attributes.weight'): {{ number_format($transactionDetail->product_weight / 1000) }} kg</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td align="right">{{ number_format($transactionDetail->product_sell_price) }}</td>
                                        <td align="right">{{ number_format($transactionDetail->quantity) }}</td>
                                        <td align="right">{{ number_format($transactionDetail->product_sell_price * $transactionDetail->quantity) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td align="right" colspan="4">@lang('cms::cms.subtotal')</td>
                                    <td align="right" >{{ number_format($transaction->total_sell_price) }}</td>
                                </tr>
                                @if ($transaction->total_discount)
                                    <tr>
                                        <td align="right" colspan="4"></td>
                                        <td align="right">{{ number_format($transaction->total_discount) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td align="right" colspan="4">@lang('cms::cms.total_shipping_cost') ({{ number_format($transaction->total_weight / 1000) }} kg)</td>
                                    <td align="right">{{ number_format($transaction->total_shipping_cost) }}</td>
                                </tr>
                                @if ($transaction->payment_fee)
                                    <tr>
                                        <td align="right" colspan="4">@lang('cms::cms.payment_fee')</td>
                                        <td align="right">{{ number_format($transaction->payment_fee) }}</td>
                                    </tr>
                                @endif
                                @if ($transaction->balance)
                                    <tr>
                                        <td align="right" colspan="4">@lang('cms::cms.balance')</td>
                                        <td align="right">-{{ number_format($transaction->balance) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td align="right" colspan="4">@lang('validation.attributes.grand_total')</td>
                                    <td align="right">{{ number_format($transaction->grand_total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('cms::cms.transaction_histories')</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">...</div>
                </div>
            </div>
        </div>
    </form>
@endsection
