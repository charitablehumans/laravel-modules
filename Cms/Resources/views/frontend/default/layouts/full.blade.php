<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="api.geocodes.regencies.index" content="{{ route('api.geocodes.regencies.index') }}" />
    <meta name="access_token" content="{{ auth()->check() ? auth()->user()->access_token : '' }}" />
    <meta name="app_name" content="{{ config('app.name') }}" />
    <meta name="app_url" content="{{ config('app.url') }}" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link href="{{ asset('css/frontend-app.css') }}" rel="stylesheet" />
    <style>
        body { padding-top: 70px; }
        footer { margin: 50px 0; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('frontend') }}">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @php
                    $term = \Modules\Menus\Models\Menus::search(['slug' => 'frontend-default-top-left'])->firstOrFail();
                    $nestable = $term->getTermmetaValues('nestable');
                    @endphp
                    {!! $term->generateAsHtml($nestable, 'frontend-default-top') !!}
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @php
                    $term = \Modules\Menus\Models\Menus::search(['slug' => 'frontend-default-top-right'])->firstOrFail();
                    $nestable = $term->getTermmetaValues('nestable');
                    @endphp
                    {!! $term->generateAsHtml($nestable, 'frontend-default-top') !!}

                    @if (auth()->guest())
                        <li><a href="{{ route('frontend.authentication.login') }}">@lang('cms::cms.login')</a></li>
                        <li><a href="{{ route('frontend.authentication.register') }}">@lang('cms::cms.register')</a></li>
                    @else
                        <li class="dropdown">
                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                {{ auth()->user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('frontend.users.profile') }}">@lang('cms::cms.profile')</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.authentication.logoutStore') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        @lang('cms::cms.logout')
                                    </a>

                                    <form action="{{ route('frontend.authentication.logoutStore') }}" id="logout-form" method="post" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                @include('flash::message')
                @yield('content')
                @yield('content_modal')
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>@lang('cms::cms.copyright') &copy; {{ config('app.name').' '.date('Y') }}</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <script src="{{ asset('js/frontend-app.js') }}"></script>
    @stack('scripts')
</body>

</html>
