@extends(request()->query('layout') ? 'cms::backend/layouts/'.request()->query('layout') : 'cms::backend/layouts/main')

@section('title', trans('cms::cms.user_game_token_histories'))
@section('content_header', trans('cms::cms.user_game_token_histories'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.user_game_token_histories')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border"></div>
        <div class="box-body table-responsive">
            <form action="{{ route('user-game-token-histories.backend.user-game-token-histories.user-id.show', $user->id) }}" method="get">
                @if (request()->query('layout') == 'media_iframe')
                    <input name="layout" type="hidden" value="{{ request()->query('layout') }}" />
                @endif
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
                                            <option {{ request()->query('sort') == 'type:asc' ? 'selected' : '' }} value="type:asc">@lang('validation.attributes.type') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'type:desc' ? 'selected' : '' }} value="type:desc">@lang('validation.attributes.type') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'reference_id:asc' ? 'selected' : '' }} value="reference_id:asc">@lang('validation.attributes.reference_id') (↓)</option>
                                            <option {{ request()->query('sort') == 'reference_id:desc' ? 'selected' : '' }} value="reference_id:desc">@lang('validation.attributes.reference_id') (↑)</option>
                                            <option {{ request()->query('sort') == 'game_token_start:asc' ? 'selected' : '' }} value="game_token:asc">@lang('validation.attributes.game_token_start') (↓)</option>
                                            <option {{ request()->query('sort') == 'game_token_start:desc' ? 'selected' : '' }} value="game_token_start:desc">@lang('validation.attributes.game_token_start') (↑)</option>
                                            <option {{ request()->query('sort') == 'game_token:asc' ? 'selected' : '' }} value="game_token:asc">@lang('validation.attributes.game_token') (↓)</option>
                                            <option {{ request()->query('sort') == 'game_token:desc' ? 'selected' : '' }} value="game_token:desc">@lang('validation.attributes.game_token') (↑)</option>
                                            <option {{ request()->query('sort') == 'game_token_end:asc' ? 'selected' : '' }} value="game_token_end:asc">@lang('validation.attributes.game_token_end') (↓)</option>
                                            <option {{ request()->query('sort') == 'game_token_end:desc' ? 'selected' : '' }} value="game_token_end:desc">@lang('validation.attributes.game_token_end') (↑)</option>
                                            <option {{ request()->query('sort') == 'notes:asc' ? 'selected' : '' }} value="notes:asc">@lang('validation.attributes.notes') (A-Z)</option>
                                            <option {{ request()->query('sort') == 'notes:desc' ? 'selected' : '' }} value="notes:desc">@lang('validation.attributes.notes') (Z-A)</option>
                                            <option {{ request()->query('sort') == 'created_at:asc' ? 'selected' : '' }} value="created_at:asc">@lang('validation.attributes.created_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'created_at:desc' ? 'selected' : '' }} value="created_at:desc">@lang('validation.attributes.created_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                @lang('validation.attributes.type')
                                <select class="form-control select2" data-allow-clear="true" data-placeholder="" name="type">
                                    <option value=""></option>
                                    @foreach ($model->getTypeOptions() as $type)
                                        <option {{ $type == request()->query('type') ? 'selected' : '' }} value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>@lang('validation.attributes.reference_id') <input class="form-control text-right" name="reference_id" type="text" value="{{ request()->query('reference_id') }}" /></th>
                            <th>
                                @lang('validation.attributes.game_token_start')
                                <select class="form-control" name="game_token_start_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('game_token_start_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('game_token_start_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="game_token_start" type="number" value="{{ request()->query('game_token_start') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.game_token')
                                <select class="form-control" name="game_token_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('game_token_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('game_token_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="game_token" type="number" value="{{ request()->query('game_token') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.game_token_end')
                                <select class="form-control" name="game_token_end_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('game_token_end_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('game_token_end_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control text-right" name="game_token_end" type="number" value="{{ request()->query('game_token_end') }}" />
                            </th>
                            <th>@lang('validation.attributes.notes') <input class="form-control" name="notes_like" type="text" value="{{ request()->query('notes_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.created_at')
                                <input autocomplete="off" class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="created_at_date" type="text" value="{{ request()->query('created_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('user-game-token-histories.backend.user-game-token-histories.user-id.show', [$user->id, 'layout' => request()->query('layout')]) }}"><i class="fa fa-repeat"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userGameTokenHistories as $i => $userGameTokenHistory)
                            <tr>
                                <td>{{ $userGameTokenHistory->type }}</td>
                                <td align="right">{{ $userGameTokenHistory->reference_id }}</td>
                                <td align="right">{{ number_format($userGameTokenHistory->game_token_start) }}</td>
                                <td align="right">{{ number_format($userGameTokenHistory->game_token) }}</td>
                                <td align="right">{{ number_format($userGameTokenHistory->game_token_end) }}</td>
                                <td>{{ $userGameTokenHistory->notes }}</td>
                                <td>{{ $userGameTokenHistory->created_at }}</td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="8">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td align="center" colspan="8">{{ $userGameTokenHistories->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
