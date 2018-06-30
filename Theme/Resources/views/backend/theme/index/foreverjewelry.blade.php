@extends('cms::backend/layouts/main')

@section('title', trans('cms::cms.theme'))
@section('content_header', trans('cms::cms.theme'))
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">@lang('cms::cms.theme')</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('backend.themes.store') }}" method="post">
        {{ csrf_field() }}
        <div class="box">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                @lang('cms::cms.desktop') <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a data-toggle="tab" href="#tab_desktop_header">@lang('cms::cms.header')</a></li>
                                <li><a data-toggle="tab" href="#tab_desktop_footer">@lang('cms::cms.footer')</a></li>
                                <li><a data-toggle="tab" href="#tab_desktop_home">@lang('cms::cms.home')</a></li>
                                <li><a data-toggle="tab" href="#tab_desktop_product_categories">@lang('cms::cms.product_categories')</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li><!-- dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                @lang('cms::cms.mobile') <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a data-toggle="tab" href="#tab_mobile_header">@lang('cms::cms.header')</a></li>
                            </ul>
                        </li><!-- dropdown -->
                    </ul><!-- nav nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_desktop_header">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Top Left Menu']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_desktop_header -->
                        <div class="tab-pane" id="tab_desktop_footer">
                            <div class="form-group">
                                <label>@lang('cms::cms.contact_us') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_footer_contact_us']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.our_store') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_footer_our_store']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.follow_us') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer Follow Us']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.about') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer About']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.help_and_support') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer Help and Support']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>GlobalSign (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer GlobalSign']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.payment') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer Payment']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.delivery_service') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Footer Delivery Service']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_desktop_footer -->
                        <div class="tab-pane" id="tab_desktop_home">
                            <div class="form-group">
                                <label>@lang('cms::cms.carousel') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Home Carousels']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.service') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Home Services']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.product_categories') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Home Product Categories Featured']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_desktop_home -->
                        <div class="tab-pane" id="tab_desktop_product_categories">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Shop Men</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>@lang('cms::cms.product_categories') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Shop Shop Men Product Categories']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.selected_collection') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_shop_shop_men_selected_collection_page']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.showcase') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Shop Shop Men Showcase']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.featured_page') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_shop_shop_men_featured_bottom_page']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </div>
                                    </div><!-- panel panel-default -->
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Shop Women</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>@lang('cms::cms.product_categories') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Shop Shop Women Product Categories']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.selected_collection') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_shop_shop_women_selected_collection_page']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.showcase') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Shop Shop Women Showcase']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="form-group">
                                                <label>@lang('cms::cms.featured_page') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => 'frontend_shop_shop_women_featured_bottom_page']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </div>
                                    </div><!-- panel panel-default -->
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Shop Gift</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>@lang('cms::cms.product_categories') (*)</label>
                                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Shop Shop Gift Product Categories']) }}"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </div>
                                    </div><!-- panel panel-default -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cms::cms.filter') (*)</label>
                                        <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Frontend Product Categories Filter Left']) }}"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- tab_desktop_product_categories -->

                        <div class="tab-pane" id="tab_mobile_header">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Mobile Frontend Top Left Menu']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') 2 (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Mobile Frontend Top Left 2 Menu']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') Social Media (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => 'Mobile Frontend Top Left Social Media Menu']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_mobile_header -->

                    </div><!-- tab-content -->
                </div><!-- nav-tabs-custom -->
            </div>
        </div>
    </form>
@endsection
