@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.sales'))
@section('content_header', trans('cms::cms.sales'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.sales')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border"></div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.transactions.sales.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="8">
                                <div class="form-inline">
                                    <div class="form-group">
                                        @lang('cms::cms.per_page')
                                        <select class="input-sm" name="limit">
                                            <option {{ request()->query('limit') == '10' ? 'selected' : '' }} value="10">10</option>
                                            <option {{ request()->query('limit') == '25' ? 'selected' : '' }} value="25">25</option>
                                            <option {{ request()->query('limit') == '50' ? 'selected' : '' }} value="50">50</option>
                                            <option {{ request()->query('limit') == '100' ? 'selected' : '' }} value="100">100</option>
                                        </select>
                                        @lang('cms::cms.sort')
                                        <select class="input-sm" name="sort">
                                            @if (auth()->user()->can('backend transactions sales all') && config('cms.transactions.sender_id'))
                                                <option {{ request()->query('sort') == 'sender_name:asc' ? 'selected' : '' }} value="sender_name:asc">@lang('cms::cms.sender') (A-Z)</option>
                                                <option {{ request()->query('sort') == 'sender_name:desc' ? 'selected' : '' }} value="sender_name:desc">@lang('cms::cms.sender') (Z-A)</option>
                                            @endif
                                            @if (config('cms.transactions.sender.store_id'))
                                                <option {{ request()->query('sort') == 'sender_store_name:asc' ? 'selected' : '' }} value="sender_store_name:asc">@lang('cms::cms.sender_store_name') (A-Z)</option>
                                                <option {{ request()->query('sort') == 'sender_store_name:desc' ? 'selected' : '' }} value="sender_store_name:desc">@lang('cms::cms.sender_store_name') (Z-A)</option>
                                            @endif
                                            <option {{ request()->query('sort') == 'number:asc' ? 'selected' : '' }} value="number:asc">@lang('validation.attributes.number') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'number:desc' ? 'selected' : '' }} value="number:desc">@lang('validation.attributes.number') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'receipt_number:asc' ? 'selected' : '' }} value="receipt_number:asc">@lang('validation.attributes.receipt_number') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'receipt_number:desc' ? 'selected' : '' }} value="receipt_number:desc">@lang('validation.attributes.receipt_number') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'grand_total:asc' ? 'selected' : '' }} value="grand_total:asc">@lang('validation.attributes.grand_total') (↓)</option>
                                            <option {{ request()->query('sort') == 'grand_total:desc' ? 'selected' : '' }} value="grand_total:desc">@lang('validation.attributes.grand_total') (↑)</option>
                                            <option {{ request()->query('sort') == 'created_at:asc' ? 'selected' : '' }} value="created_at:asc">@lang('validation.attributes.created_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'created_at:desc' ? 'selected' : '' }} value="created_at:desc">@lang('validation.attributes.created_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="hidden"><input class="table_row_checkbox_all" type="checkbox" /></th>
                            @if (auth()->user()->can('backend transactions sales all') && config('cms.transactions.sender_id'))
                                <th>
                                    @lang('cms::cms.sender')<br />
                                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="sender_id">
                                        <option value=""></option>
                                        @foreach ($model->getSenderIdOptions() as $senderId => $senderName)
                                            <option {{ $senderId == request()->query('sender_id') ? 'selected' : '' }} value="{{ $senderId }}">{{ $senderName }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endif
                            @if (config('cms.transactions.sender.store_id'))
                                <th>
                                    @lang('cms::cms.sender_store_name')<br />
                                    <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="sender_store_id">
                                        <option value=""></option>
                                        @foreach ($model->getStoreIdNameOptions() as $storeId => $storeName)
                                            <option {{ $storeId == request()->query('sender_store_id') ? 'selected' : '' }} value="{{ $storeId }}">{{ $storeName }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endif
                            <th>@lang('validation.attributes.number') <input class="form-control" name="number_like" type="text" value="{{ request()->query('number_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.status')
                                <select class="form-control" name="status">
                                    <option value=""></option>
                                    @foreach ($model->getStatusOptions() as $status => $statusName)
                                        <option {{ $status == request()->query('status') ? 'selected' : '' }} value="{{ $status }}">{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>@lang('validation.attributes.receipt_number') <input class="form-control" name="receipt_number_like" type="text" value="{{ request()->query('receipt_number_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.grand_total')
                                <select class="form-control" name="grand_total_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('grand_total_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('grand_total_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="grand_total" type="number" value="{{ request()->query('grand_total') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.created_at')
                                <input autocomplete="off" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="created_at_date" type="text" value="{{ request()->query('created_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.transactions.sales.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $i => $transaction)
                            <tr>
                                <td align="center" style="display: none"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $transaction->id }}" /></td>
                                @if (auth()->user()->can('backend transactions sales all') && config('cms.transactions.sender_id'))
                                    <td>{{ $transaction->getSender()->name }}</td>
                                @endcan
                                @if (config('cms.transactions.sender.store_id'))
                                    <td>{{ $transaction->getSender()->getStore()->name }}</td>
                                @endif
                                <td>
                                    <a href="{{ route('backend.transactions.sales.show', $transaction->id) }}" target="_blank">
                                        {{ $transaction->number }}
                                    </a>
                                </td>
                                <td>@lang('cms::cms.'.$transaction->status)</td>
                                <td>{{ $transaction->receipt_number }}</td>
                                <td>{{ number_format($transaction->grand_total) }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td align="center">
                                    @if (in_array($transaction->status, ['new']))
                                        <a class="btn btn-primary btn-xs" href="{{ route('backend.transactions.sales.process', $transaction->id) }}">@lang('cms::cms.process')</a>
                                        <a class="btn btn-danger btn-xs" href="{{ route('backend.transactions.sales.reject', $transaction->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_reject_this')?')">@lang('cms::cms.reject')</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="8">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <select class="input-xs" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="8">{{ $transactions->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
