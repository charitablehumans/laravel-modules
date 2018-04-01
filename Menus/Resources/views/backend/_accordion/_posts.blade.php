<div class="panel panel-default">
    <div class="panel-heading" id="headingPosts" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapsePosts" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapsePosts" role="button">@lang('cms::cms.posts')</a>
        </h4>
    </div>
    <div aria-labelledby="headingPosts" class="panel-collapse collapse in" id="collapsePosts" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="post">
                    <option></option>
                    @foreach ($term->getPostIdOptions() as $postId => $postTitle)
                        <option value="{{ $postId }}">{{ $postTitle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default pull-right" id="post_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#post_add').click(function () {
        var post = document.getElementById('post');

        if (post.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', post.value)
                .replace('$data_title', post.options[post.selectedIndex].text)
                .replace('$data_title', post.options[post.selectedIndex].text)
                .replace('$data_type', 'post')
                .replace('$data_type', 'post');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(post).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
