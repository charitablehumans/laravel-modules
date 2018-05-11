{{ csrf_field() }}
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <input name="locale" type="hidden" value="{{ request()->old('locale', request()->query('locale', config('app.locale'))) }}" />
                @foreach (config('app.languages') as $languageCode => $languageName)
                    @if ($post->id)
                        @php $languageHref = route('backend.product-testimonials.edit', ['id' => $post->id, 'locale' => $languageCode]) @endphp
                    @else
                        @php $languageHref = route('backend.product-testimonials.create', ['locale' => $languageCode]) @endphp
                    @endif

                    <a href="{{ $languageHref }}">
                        <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                    </a>
                    {{ $languageCode == request()->old('locale', request()->query('locale', config('app.locale'))) ? $languageName : '' }}
                @endforeach
                <hr />

                @can('backend product testimonials all')
                    <div class="form-group">
                        <label>@lang('validation.attributes.author')</label>
                        <select class="form-control select2" name="author_id">
                            @foreach ($post->getAuthorIdNameOptions() as $authorId => $authorName)
                                <option {{ $authorId == $post->getAuthorId() ? 'selected' : '' }} value="{{ $authorId }}">{{ $authorName }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input name="author_id" type="hidden" value="{{ auth()->user()->id }}" />
                @endcan

                <div class="form-group">
                    <label>@lang('validation.attributes.parent')</label>
                    <select class="form-control select2" name="parent_id">
                        @foreach ($parent->getIdTitleOptions() as $parentId => $parentTitle)
                            <option {{ $parentId == $post->getParentId() ? 'selected' : '' }} value="{{ $parentId }}">{{ $parentTitle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.content')</label>
                    <textarea class="form-control tinymce" name="content" rows="6">{{ request()->old('content', $post_translation->content) }}</textarea>
                    <i class="text-danger">{{ $errors->first('content') }}</i>
                </div>
                @include('producttestimonials::backend/product_testimonials/_testimonial')
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <label>@lang('validation.attributes.status')</label>
                    <select class="form-control" name="status">
                        @foreach ($post->getStatusOptions() as $statusValue => $statusName)
                            <option {{ $statusValue == $post->getStatus() ? 'selected' : '' }} value="{{ $statusValue }}">{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('cms::cms.images')</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" title="" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <input class="images_media_id" name="postmetas[images][]" type="hidden" value="" />
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
                            <input class="images_media_id" name="postmetas[images][]" type="hidden" value="$images_media_id" />
                            <div style="position: relative;">
                                <a class="images_media_attached_file" data-fancybox="group" href="$images_media_attached_file" target="_blank">
                                    <img class="contain images_media_attached_file_thumbnail media-object" src="$images_media_attached_file_thumbnail" style="height: 64px; width: 64px;" />
                                </a>
                                <button class="close template_close" type="button"><span>&times;</span></button>
                            </div>
                        </li>
                    </template>

                    @foreach ($post->getPostmetaByKey('images')->getMedia() as $medium)
                        <li>
                            <input class="images_media_id" name="postmetas[images][]" type="hidden" value="{{ $medium->id }}" />
                            <div style="position: relative;">
                                <a class="images_media_attached_file" data-fancybox="group" href="{{ \Storage::url($medium->getPostmetaValue('attached_file')) }}" target="_blank">
                                    <img class="contain images_media_attached_file_thumbnail media-object" src="{{ \Storage::url($medium->getPostmetaValue('attached_file_thumbnail')) }}" style="height: 64px; width: 64px;" />
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
