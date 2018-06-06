{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>@lang('cms::cms.product') (*)</label>
                    <select class="form-control input-sm select2" data-allow-clear="true" data-placeholder="" name="post_id" required>
                        <option value=""></option>
                        @foreach ($model->getPostIdTitleOptions() as $postId => $postTitle)
                            <option {{ $postId == request()->old('post_id', $model->post_id) ? 'selected' : '' }} value="{{ $postId }}">{{ $postTitle }}</option>
                        @endforeach
                    </select>
                    <i class="text-danger">{{ $errors->first('post_id') }}</i>
                </div>
                <div class="form-group">
                    <label>@lang('cms::cms.user') (*)</label>
                    <select class="form-control input-sm select2" data-allow-clear="true" data-placeholder="" name="user_id" required>
                        <option value=""></option>
                        @foreach ($model->getUserIdEmailOptions() as $userId => $userEmail)
                            <option {{ $userId == request()->old('user_id', $model->user_id) ? 'selected' : '' }} value="{{ $userId }}">{{ $userEmail }}</option>
                        @endforeach
                    </select>
                    <i class="text-danger">{{ $errors->first('user_id') }}</i>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input class="btn btn-sm btn-success" type="submit" value="@lang('cms::cms.save')" />
                </div>
            </div>
        </div>
    </div>
</div>
