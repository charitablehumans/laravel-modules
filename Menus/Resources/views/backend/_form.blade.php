{{ csrf_field() }}
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <input name="locale" type="hidden" value="{{ request()->old('locale', request()->query('locale', config('app.locale'))) }}" />
                @foreach (config('app.languages') as $languageCode => $languageName)
                    @if ($term->id)
                        @php $languageHref = route('backend.menus.edit', ['id' => $term->id, 'locale' => $languageCode]) @endphp
                    @else
                        @php $languageHref = route('backend.menus.create', ['locale' => $languageCode]) @endphp
                    @endif

                    <a href="{{ $languageHref }}">
                        <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                    </a>
                    {{ $languageCode == request()->old('locale', request()->query('locale', config('app.locale'))) ? $languageName : '' }}
                @endforeach
                <hr />
                <div class="form-group">
                    <label>@lang('validation.attributes.name') (*)</label>
                    <input class="form-control input-sm" name="name" required type="text" value="{{ request()->old('name', $term_translation->name) }}" />
                    <i class="text-danger">{{ $errors->first('name') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.description')</label>
                    <textarea class="form-control input-sm" name="description" rows="3">{{ request()->old('description', $term_translation->description) }}</textarea>
                    <i class="text-danger">{{ $errors->first('description') }}</i>
                </div>
            </div>
            <div class="box-footer">
                <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('validation.attributes.template')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <select class="form-control input-sm" name="termmetas[template]">
                    @foreach ($term->getTemplateOptions() as $templateId => $templateName)
                        <option {{ $templateId == $term->getTermmetaValue('template') ? 'selected' : '' }} value="{{ $templateId }}">{{ $templateName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div aria-multiselectable="true" class="panel-group" id="accordion" role="tablist">
            @include('menus::backend/_accordion/_categories', ['term' => $term])
            @include('menus::backend/_accordion/_custom_links', ['term' => $term])
            @if (config('cms.menus.accordion.doku_myshortcart_payment_methods'))
                @include('menus::backend/_accordion/_doku_myshortcart_payment_methods', ['term' => $term])
            @endif
            @include('menus::backend/_accordion/_pages', ['term' => $term])
            @include('menus::backend/_accordion/_posts', ['term' => $term])
            @if (config('cms.menus.accordion.products'))
                @include('menus::backend/_accordion/_products', ['term' => $term])
            @endif
            @if (config('cms.menus.accordion.product_categories'))
                @include('menus::backend/_accordion/_product_categories', ['term' => $term])
            @endif
            @if (config('cms.menus.accordion.product_testimonials'))
                @include('menus::backend/_accordion/_product_testimonials', ['term' => $term])
            @endif
            @include('menus::backend/_accordion/_tags', ['term' => $term])
        </div>
    </div>
    <div class="col-md-9">
        <div class="box">
            @include('menus::backend/_nestable')
        </div>
    </div>
</div>
