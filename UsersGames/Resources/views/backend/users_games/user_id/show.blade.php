@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.user_game_histories'))
@section('content_header', trans('cms::cms.user_game_histories'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.user_game_histories')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border"></div>
        <div class="box-body table-responsive">
            <form action="{{ route('users-games.backend.users-games.user-id.show', $user->id) }}" method="get">
                @if (request()->query('layout') == 'media_iframe')
                    <input name="layout" type="hidden" value="{{ request()->query('layout') }}" />
                @endif
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="5">
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
                                            <option {{ request()->query('sort') == 'token:asc' ? 'selected' : '' }} value="token:asc">@lang('validation.attributes.token') (↓)</option>
                                            <option {{ request()->query('sort') == 'token:desc' ? 'selected' : '' }} value="token:desc">@lang('validation.attributes.token') (↑)</option>
                                            <option {{ request()->query('sort') == 'finished:asc' ? 'selected' : '' }} value="finished:asc">@lang('validation.attributes.finished') (↓)</option>
                                            <option {{ request()->query('sort') == 'finished:desc' ? 'selected' : '' }} value="finished:desc">@lang('validation.attributes.finished') (↑)</option>
                                            <option {{ request()->query('sort') == 'balance:asc' ? 'selected' : '' }} value="balance:asc">@lang('validation.attributes.balance') (↓)</option>
                                            <option {{ request()->query('sort') == 'balance:desc' ? 'selected' : '' }} value="balance:desc">@lang('validation.attributes.balance') (↑)</option>
                                            <option {{ request()->query('sort') == 'created_at:asc' ? 'selected' : '' }} value="created_at:asc">@lang('validation.attributes.created_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'created_at:desc' ? 'selected' : '' }} value="created_at:desc">@lang('validation.attributes.created_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                @lang('validation.attributes.token')
                                <select class="form-control" name="token_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('token_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('token_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="token" type="number" value="{{ request()->query('token') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.finished')
                                <select class="form-control" name="finished_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('finished_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('finished_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="finished" type="number" value="{{ request()->query('finished') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.balance')
                                <select class="form-control" name="balance_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('balance_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('balance_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="balance" type="number" value="{{ request()->query('balance') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.created_at')
                                <input autocomplete="off" class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="created_at_date" type="text" value="{{ request()->query('created_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('users-games.backend.users-games.user-id.show', [$user->id, 'layout' => request()->query('layout')]) }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userGames as $i => $userGame)
                            <tr>
                                <td align="right">{{ number_format($userGame->token) }}</td>
                                <td align="right">{{ number_format($userGame->finished) }}</td>
                                <td align="right">{{ number_format($userGame->balance) }}</td>
                                <td>{{ $userGame->created_at }}</td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="5">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td align="center" colspan="5">{{ $userGames->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
