<hr />
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>@lang('cms::cms.product_sku')</label>
            <input class="form-control" name="postmetas[product_sku]" type="text" value="{{ request()->old('postmetas.product_sku', $post->getPostmetaValue('product_sku')) }}" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('cms::cms.product_detail')</label>
            <textarea class="form-control tinymce" name="content_2" rows="6">{{ $post->getContent2() }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('cms::cms.size_guide')</label>
            <textarea class="form-control tinymce" name="content_3" rows="6">{{ $post->getContent3() }}</textarea>
        </div>
    </div>
</div>
