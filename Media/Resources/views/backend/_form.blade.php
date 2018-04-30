{{ csrf_field() }}
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <input name="locale" type="hidden" value="{{ request()->old('locale', request()->query('locale', config('app.locale'))) }}" />
                @foreach (config('app.languages') as $languageCode => $languageName)
                    @if ($post->id)
                        @php $languageHref = route('backend.media.edit', ['id' => $post->id, 'locale' => $languageCode]) @endphp
                    @else
                        @php $languageHref = route('backend.media.create', ['locale' => $languageCode]) @endphp
                    @endif

                    <a href="{{ $languageHref }}">
                        <img src="{{ asset('images/flags/'.$languageCode.'.gif') }}" />
                    </a>
                    {{ $languageCode == request()->old('locale', request()->query('locale', config('app.locale'))) ? $languageName : '' }}
                @endforeach
                <hr />
                <div class="form-group">
                    <label>@lang('validation.attributes.name') (*)</label>
                    <input class="form-control input-sm" name="title" required type="text" value="{{ request()->old('title', $post_translation->title) }}" />
                    <i class="text-danger">{{ $errors->first('title') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.slug')</label>
                    <input class="form-control input-sm" name="name" readonly required type="text" value="{{ request()->old('name', $post_translation->name) }}" />
                    <i class="text-danger">{{ $errors->first('name') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('cms::cms.caption')</label>
                    <textarea class="form-control input-sm" name="excerpt" rows="3">{{ request()->old('excerpt', $post_translation->excerpt) }}</textarea>
                    <i class="text-danger">{{ $errors->first('excerpt') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('cms::cms.description')</label>
                    <textarea class="form-control input-sm" name="content" rows="3">{{ request()->old('content', $post_translation->content) }}</textarea>
                    <i class="text-danger">{{ $errors->first('content') }}</i>
                </div>
                @if ($post->id)
                    @php
                    $attachment_metadata = $post->getPostmetaValues('attachment_metadata');
                    @endphp

                    <div class="row">
                        <div class="col-md-4">
                            <input name="postmetas[attached_file]" type="hidden" value="{{ $post->getPostmetaValue('attached_file') }}" />
                            <input name="postmetas[attached_file_thumbnail]" type="hidden" value="{{ $post->getPostmetaValue('attached_file_thumbnail') }}" />
                            <input name="postmetas[attachment_metadata]" type="hidden" value="{{ json_encode($attachment_metadata) }}" />
                            <a
                                @if (in_array($post->mime_type, $post->mimeTypeImages)) data-fancybox="group" @endif
                                href="{{ Storage::url($post->getPostmetaValue('attached_file')) }}" target="_blank"
                            >
                                <img class="contain media-object" src="{{ Storage::url($post->getPostmetaValue('attached_file_thumbnail')) }}" style="height: 150px; width: 150px;" />
                            </a>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td width="20%">@lang('cms::cms.file_url')</td>
                                        <td width="1%">:</td>
                                        <td>{{ $post->getPostmetaValue('attached_file') }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('cms::cms.file_type')</td>
                                        <td>:</td>
                                        <td>{{ $post->mime_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('cms::cms.extension')</td>
                                        <td>:</td>
                                        <td>{{ $attachment_metadata['extension'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('cms::cms.file_size')</td>
                                        <td>:</td>
                                        <td>
                                            {{ Conversion::convert($attachment_metadata['size'], 'byte')->to('megabyte') }} MB
                                            ({{ number_format($attachment_metadata['size']) }} B)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <label>@lang('validation.attributes.status')</label>
                    <select class="form-control input-sm" name="status">
                        @foreach (collect($post->getStatusOptions())->except('draft') as $statusValue => $statusName)
                            <option {{ $statusValue == request()->old('status', $post->status) ? 'selected' : '' }} value="{{ $statusValue }}">{{ $statusName }}</option>
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
                <h3 class="box-title">@lang('cms::cms.categories')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="categories-container">
                    <input name="postmetas[categories][]" type="hidden" value="" />
                    @foreach ($post->getCategoriesTree() as $category_tree)
                        <div class="checkbox">
                            {{ $category_tree['tree_prefix'] }}
                            <label>
                                <input {{ in_array($category_tree['id'], $post->getPostmetaValues('categories')) ? 'checked' : '' }} name="postmetas[categories][]" type="checkbox" value="{{ $category_tree['id'] }}" /> {{ $category_tree['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('cms::cms.tags')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <input name="postmetas[tags][]" type="hidden" value="" />
                <select class="form-control input-sm select2" data-width="100%" multiple="multiple" name="postmetas[tags][]">
                    @foreach ($post->getTagIdOptions() as $tagId => $tagName)
                        <option {{ in_array($tagId, $post->getPostmetaValues('tags')) ? 'selected' : '' }} value="{{ $tagId }}">{{ $tagName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('cms::cms.related_media')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <input class="images_media_id" name="postmetas[related_media][]" type="hidden" value="" />
                <u>
                    <a
                        data-fancybox
                        data-type="iframe"
                        href="{{ route('backend.media.index', ['fancybox_to' => 'related_media', 'layout' => 'media_iframe', 'mime_type_like' => 'image/']) }}"
                    >@lang('cms::cms.choose')</a>
                </u>
                <ul class="list-inline sortable-list-group" id="related_media">
                    <template class="hidden" id="related_media_template">
                        <li>
                            <input class="images_media_id" name="postmetas[related_media][]" type="hidden" value="$images_media_id" />
                            <div style="position: relative;">
                                <a class="images_media_attached_file" data-fancybox="group" href="$images_media_attached_file" target="_blank">
                                    <img class="contain images_media_attached_file_thumbnail media-object" src="$images_media_attached_file_thumbnail" style="height: 64px; width: 64px;" />
                                </a>
                                <button class="close template_close" type="button"><span>&times;</span></button>
                            </div>
                        </li>
                    </template>

                    @foreach ($post->getPostmetaByKey('related_media')->getMedia() as $medium)
                        <li>
                            <input class="images_media_id" name="postmetas[related_media][]" type="hidden" value="{{ $medium->id }}" />
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
