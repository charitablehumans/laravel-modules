@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.products'))
@section('content_header', trans('cms::cms.products'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.products')</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <a class="btn btn-primary btn-sm" href="{{ route('backend.products.create', request()->query()) }}">@lang('cms::cms.create')</a>
        </div>
        <div class="box-body table-responsive">
            <form action="{{ route('backend.products.index') }}" method="get">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th class="text-right" colspan="10">
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
                                            <option {{ request()->query('sort') == 'post_product_stock:asc' ? 'selected' : '' }} value="post_product_stock:asc">@lang('validation.attributes.stock') (↓)</option>
                                            <option {{ request()->query('sort') == 'post_product_stock:desc' ? 'selected' : '' }} value="post_product_stock:desc">@lang('validation.attributes.stock') (↑)</option>
                                            <option {{ request()->query('sort') == 'post_product_sell_price:asc' ? 'selected' : '' }} value="post_product_sell_price:asc">@lang('validation.attributes.sell_price') (↓)</option>
                                            <option {{ request()->query('sort') == 'post_product_sell_price:desc' ? 'selected' : '' }} value="post_product_sell_price:desc">@lang('validation.attributes.sell_price') (↑)</option>
                                            <option {{ request()->query('sort') == 'status:asc' ? 'selected' : '' }} value="status:asc">@lang('validation.attributes.status') (↓)</option>
                                            <option {{ request()->query('sort') == 'status:desc' ? 'selected' : '' }} value="status:desc">@lang('validation.attributes.status') (↑)</option>
                                            @if (config('cms.products.product_testimonials.rating_average'))
                                                <option {{ request()->query('sort') == 'post_testimonial_rating_average:asc' ? 'selected' : '' }} value="post_testimonial_rating_average:asc">@lang('validation.attributes.rating') (↓)</option>
                                                <option {{ request()->query('sort') == 'post_testimonial_rating_average:desc' ? 'selected' : '' }} value="post_testimonial_rating_average:desc">@lang('validation.attributes.rating') (↑)</option>
                                            @endif
                                            <option {{ request()->query('sort') == 'updated_at:asc' ? 'selected' : '' }} value="updated_at:asc">@lang('validation.attributes.updated_at') (↓)</option>
                                            <option {{ request()->query('sort') == 'updated_at:desc' ? 'selected' : '' }} value="updated_at:desc">@lang('validation.attributes.updated_at') (↑)</option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th><input class="table_row_checkbox_all" type="checkbox" /></th>
                            <th>@lang('validation.attributes.locale')</th>
                            <th>@lang('validation.attributes.name') <input class="form-control input-sm" name="title_like" type="text" value="{{ request()->query('title_like') }}" /></th>
                            <th>
                                @lang('validation.attributes.stock')
                                <select class="form-control input-sm" name="post_product_stock_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('post_product_stock_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('post_product_stock_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control input-sm text-right" name="post_product_stock" type="number" value="{{ request()->query('post_product_stock') }}" />
                            </th>
                            <th>
                                @lang('validation.attributes.sell_price')
                                <select class="form-control input-sm" name="post_product_sell_price_operator">
                                    <option value="">=</option>
                                    <option {{ request()->query('post_product_sell_price_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                    <option {{ request()->query('post_product_sell_price_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                </select>
                                <input class="form-control input-sm text-right" name="post_product_sell_price" type="number" value="{{ request()->query('post_product_sell_price') }}" />
                            </th>
                            <th>
                                @lang('cms::cms.categories')
                                <select class="form-control input-sm" name="category_id">
                                    <option value=""></option>
                                    @foreach ($model->getCategoryIdOptions() as $categoryId => $categoryName)
                                        <option {{ $categoryId == request()->input('category_id') ? 'selected' : '' }} value="{{ $categoryId }}">{{ $categoryName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                @lang('validation.attributes.status')
                                <select class="form-control input-sm" name="status">
                                    <option value=""></option>
                                    @foreach ($model->status_options as $statusId => $statusName)
                                        <option {{ $statusId == request()->query('status') ? 'selected' : '' }} value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @if (config('cms.products.product_testimonials.rating_average'))
                                <th>
                                    @lang('validation.attributes.rating')
                                    <select class="form-control input-sm" name="post_testimonial_rating_average_operator">
                                        <option value="">=</option>
                                        <option {{ request()->query('post_testimonial_rating_average_operator') == '>' ? 'selected' : '' }} value=">">></option>
                                        <option {{ request()->query('post_testimonial_rating_average_operator') == '<' ? 'selected' : '' }} value="<"><</option>
                                    </select>
                                    <input class="form-control input-sm text-right" name="post_testimonial_rating_average" type="number" value="{{ request()->query('post_testimonial_rating_average') }}" />
                                </th>
                            @endif
                            <th>
                                @lang('validation.attributes.updated_at')
                                <input class="datepicker form-control input-sm" data-date-format="yyyy-mm-dd" name="updated_at_date" type="text" value="{{ request()->query('updated_at_date') }}" />
                            </th>
                            <th>
                                <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-search"></i></button>
                                <a class="btn btn-default btn-xs" href="{{ route('backend.products.index') }}"><i class="fa fa-repeat"></i></a>
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
                                            <a href="{{ route('backend.products.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                                            </a>
                                        @else
                                            <a href="{{ route('backend.products.edit', [$post->id] + ['locale' => $languageCode]) }}">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $post->title }}</td>
                                <td align="right">{{ $post->postProduct->getStockUnlimited().number_format($post->postProduct->stock) }}</td>
                                <td align="right">{{ number_format($post->postProduct->sell_price) }}</td>
                                <td>
                                    @if ($categories = $post->getPostmetaByKey('categories')->getCategories())
                                        <ol>
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('backend.categories.edit', [$category->id]) }}">{{ $category->name }}</a><br />
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td>@lang('cms::cms.'.$post->status)</td>
                                @if (config('cms.products.product_testimonials.rating_average'))
                                    <td align="right">{{ optional($post->postTestimonial)->rating_average }}</td>
                                @endif
                                <td>{{ $post->updated_at }}</td>
                                <td align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('backend.products.edit', [$post->id] + request()->query()) }}"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('backend.products.trash', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this')?')"><i class="fa fa-trash-o"></i></a>
                                    @can('backend products delete')
                                        <a class="btn btn-danger btn-xs" href="{{ route('backend.products.delete', $post->id) }}" onclick="return confirm('@lang('cms::cms.are_you_sure_to_delete_this_permanently')?')"><i class="fa fa-trash-o"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="10">@lang('cms::cms.no_data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <select class="input-sm" name="action">
                                    <option value="">@lang('cms::cms.action')</option>
                                    @foreach ($model->getStatusOptions() as $statusId => $statusName)
                                        <option value="{{ $statusId }}">{{ $statusName }}</option>
                                    @endforeach
                                    @can('backend pages delete')
                                        <option value="delete">@lang('cms::cms.delete')</option>
                                    @endcan
                                </select>
                                <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-play-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="10">{{ $posts->appends(request()->query())->links('cms::vendor/pagination/default-2') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
