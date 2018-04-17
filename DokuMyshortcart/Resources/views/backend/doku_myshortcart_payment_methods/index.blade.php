@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.payment_methods'))
@section('content_header', trans('cms::cms.payment_methods'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.payment_methods')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-default btn-sm" href="{{ route('backend.doku-myshortcart-payment-methods.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.doku-myshortcart-payment-methods.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="7">
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
                                            <option {{ request()->query('sort') == 'title:asc' ? 'selected' : '' }} value="title:asc">@lang('validation.attributes.name') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'title:desc' ? 'selected' : '' }} value="title:desc">@lang('validation.attributes.name') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'postmetas.PAYMENTMETHODID:asc' ? 'selected' : '' }} value="postmetas.PAYMENTMETHODID:asc">@lang('cms::cms.payment_method_id') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'postmetas.PAYMENTMETHODID:desc' ? 'selected' : '' }} value="postmetas.PAYMENTMETHODID:desc">@lang('cms::cms.payment_method_id') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'postmetas.payment_fee_formula:asc' ? 'selected' : '' }} value="postmetas.payment_fee_formula:asc">@lang('cms::cms.payment_fee_formula') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'postmetas.payment_fee_formula:desc' ? 'selected' : '' }} value="postmetas.payment_fee_formula:desc">@lang('cms::cms.payment_fee_formula') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'status:asc' ? 'selected' : '' }} value="status:asc">@lang('validation.attributes.status') (↓)</option>
                                            <option {{ request()->query('sort') == 'status:desc' ? 'selected' : '' }} value="status:desc">@lang('validation.attributes.status') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="title_like" type="text" value="{{ request()->query('title_like') }}" /></th>
                            <th>@lang('cms::cms.payment_method_id') <input class="form-control input-sm" name="payment_method_id_like" type="text" value="{{ request()->query('payment_method_id_like') }}" /></th>
                            <th>@lang('cms::cms.payment_fee_formula') <input class="form-control input-sm" name="payment_fee_formula_like" type="text" value="{{ request()->query('payment_fee_formula_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.status')
                                <select class="form-control input-sm" name="status">
                                    <option value=""></option>
                                    @foreach ($model->status_options as $statusId => $statusName)
                                        <option {{ $statusId == request()->query('status') ? 'selected' : '' }} value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.doku-myshortcart-payment-methods.index') }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $i => $post)
                            <tr>
                                <td align="center"><input class="table_row_checkbox" name="action_id[]" type="checkbox" value="{{ $post->id }}" /></td>
                                <td>
                                    @foreach (config('app.languages') as $languageCode => $languageName)
                                        @if ($post->hasTranslation($languageCode))
                                            <a href="{{ route('backend.doku-myshortcart-payment-methods.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.doku-myshortcart-payment-methods.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->getPostmetaPaymentMethodId() }}</td>
                                <td>{{ $post->getPostmetaPaymentFeeFormula() }}</td>
                                <td>@lang('cms::cms.'.$post->status)</td>
                                <td align="center">
                                    <a class="btn btn-default btn-xs" href="{{ route('backend.doku-myshortcart-payment-methods.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.doku-myshortcart-payment-methods.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="7">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <select class="input-sm" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    <option value="delete">@lang('cms::cms.delete')</option>
                                </select>
                                <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="7">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
