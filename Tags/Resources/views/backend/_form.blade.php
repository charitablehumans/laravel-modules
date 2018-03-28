{{ csrf_field() }}
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <input name="locale" type="hidden" value="{{ request()->old('locale', request()->query('locale', config('app.locale'))) }}" />
                @foreach (config('app.languages') as $languageCode => $languageName)
                    @if ($term->id)
                        @php $languageHref = route('backend.tags.edit', ['id' => $term->id, 'locale' => $languageCode]) @endphp
                    @else
                        @php $languageHref = route('backend.tags.create', ['locale' => $languageCode]) @endphp
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
                    <label>@lang('validation.attributes.slug')</label>
                    <input class="form-control input-sm" readonly type="text" value="{{ request()->old('slug', $term_translation->slug) }}" />
                    <i class="text-danger">{{ $errors->first('slug') }}</i>
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
                        <option {{ $templateId == $term->getTermmetaTemplate() ? 'selected' : '' }} value="{{ $templateId }}">{{ $templateName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('cms::cms.images')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <input class="images_media_id" name="termmetas[images][]" type="hidden" value="" />
                <u>
                    <a
                        data-fancybox
                        data-type="iframe"
                        href="{{ route('backend.media.index', ['fancybox_to' => 'images', 'layout' => 'media_iframe', 'mime_type_like' => 'image/']) }}"
                    >@lang('cms::cms.choose')</a>
                </u>
                <ul class="list-inline sortable-list-group" id="images">
                    <template class="hidden" id="images_template">
                        <li>
                            <input class="images_media_id" name="termmetas[images][]" type="hidden" value="$images_media_id" />
                            <div style="position: relative;">
                                <a class="images_media_attached_file" data-fancybox="group" href="$images_media_attached_file" target="_blank">
                                    <img class="images_media_attached_file_thumbnail media-object" src="$images_media_attached_file_thumbnail" style="height: 64px; width: 64px;" />
                                </a>
                                <button class="close template_close" type="button"><span>&times;</span></button>
                            </div>
                        </li>
                    </template>

                    @foreach ($term->getTermmetaImagesId() as $imageId)
                        @php $medium = \App\Http\Models\Media::find($imageId); @endphp

                        <li>
                            <input class="images_media_id" name="termmetas[images][]" type="hidden" value="{{ $imageId }}" />
                            <div style="position: relative;">
                                <a class="images_media_attached_file" data-fancybox="group" href="{{ Storage::url($medium->getPostmetaAttachedFile()) }}" target="_blank">
                                    <img class="images_media_attached_file_thumbnail media-object" src="{{ Storage::url($medium->getPostmetaAttachedFileThumbnail()) }}" style="height: 64px; width: 64px;" />
                                </a>
                                <button class="close template_close" type="button"><span>&times;</span></button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
