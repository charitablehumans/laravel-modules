{{ csrf_field() }}
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-body">
                <input name="locale" type="hidden" value="{{ request()->old('locale', request()->query('locale', config('app.locale'))) }}" />
                @foreach (config('app.languages') as $languageCode => $languageName)
                    @if ($post->id)
                        @php $languageHref = route('backend.categories.edit', ['id' => $post->id, 'locale' => $languageCode]) @endphp
                    @else
                        @php $languageHref = route('backend.categories.create', ['locale' => $languageCode]) @endphp
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
                    <label>@lang('validation.attributes.excerpt')</label>
                    <textarea class="form-control input-sm" name="excerpt" rows="3">{{ request()->old('excerpt', $post_translation->excerpt) }}</textarea>
                    <i class="text-danger">{{ $errors->first('excerpt') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('validation.attributes.content')</label>
                    <textarea class="form-control tinymce" name="content" rows="6">{{ request()->old('content', $post_translation->content) }}</textarea>
                    <i class="text-danger">{{ $errors->first('content') }}</i>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Doku</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-original-title="Collapse" data-toggle="tooltip" data-widget="collapse" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>@lang('cms::cms.payment_method_id')</label>
                                        <input class="form-control input-sm" name="postmetas[PAYMENTMETHODID]" type="text" value="{{ request()->old('postmetas.PAYMENTMETHODID', $post->getPostmetaPaymentMethodId()) }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('cms::cms.payment_fee_formula')</label>
                                        <input class="form-control input-sm" name="postmetas[payment_fee_formula]" type="text" value="{{ $post->getPostmetaPaymentFeeFormula() }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <label>@lang('validation.attributes.status')</label>
                    <select class="form-control input-sm" name="status">
                        @foreach ($post->getStatusOptions() as $statusValue => $statusName)
                            <option {{ $statusValue == request()->old('status', $post->status) ? 'selected' : '' }} value="{{ $statusValue }}">{{ $statusName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input class="btn btn-default btn-sm" type="submit" value="@lang('cms::cms.save')" />
                </div>
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

                    @foreach ($post->getPostmetaValues('images') as $imageId)
                        @if ($medium = \Modules\Media\Models\Media::find($imageId))
                            <li>
                                <input class="images_media_id" name="postmetas[images][]" type="hidden" value="{{ $imageId }}" />
                                <div style="position: relative;">
                                    <a class="images_media_attached_file" data-fancybox="group" href="{{ Storage::url($medium->getPostmetaValue('attached_file')) }}" target="_blank">
                                        <img class="contain images_media_attached_file_thumbnail media-object" src="{{ Storage::url($medium->getPostmetaValue('attached_file_thumbnail')) }}" style="height: 64px; width: 64px;" />
                                    </a>
                                    <button class="close template_close" type="button"><span>&times;</span></button>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
