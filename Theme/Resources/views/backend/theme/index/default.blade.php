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
                                <li class="divider"></li>
                            </ul>
                        </li><!-- dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                @lang('cms::cms.mobile') <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a data-toggle="tab" href="#tab_mobile_header">@lang('cms::cms.header')</a></li>
                                <li><a data-toggle="tab" href="#tab_mobile_footer">@lang('cms::cms.footer')</a></li>
                            </ul>
                        </li><!-- dropdown -->
                    </ul><!-- nav nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_desktop_header">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_desktop_header -->
                        <div class="tab-pane" id="tab_desktop_footer">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_desktop_footer -->

                        <div class="tab-pane" id="tab_mobile_header">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_mobile_header -->
                        <div class="tab-pane" id="tab_mobile_footer">
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.menus.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                            <div class="form-group">
                                <label>@lang('cms::cms.menu') (*)</label>
                                <a data-fancybox data-type="iframe" href="{{ route('backend.options.index', ['layout' => 'media_iframe', 'name' => '']) }}"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div><!-- tab_mobile_footer -->

                    </div><!-- tab-content -->
                </div><!-- nav-tabs-custom -->
            </div>
            <div class="box-footer hidden">
                <div class="form-group">
                    <input class="btn btn-success" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </form>
@endsection
