<?php

namespace Modules\Media\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\Media\Models\Media;
use Modules\Postmetas\Models\Postmetas;

class MediaController extends \Modules\Posts\Http\Controllers\Backend\PostsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Media;
    }

    public function index(Request $request)
    {
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'updated_at:desc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = $this->model;
        $data['posts'] = $this->model::with(['author', 'postmetas'])
            ->select($this->model->getTable().'.*')
            ->search($request->query())
            ->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('media::backend/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('media::backend/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['post'] = $post = $this->model::search(['id' => $id])->firstOrFail();
        $data['post_translation'] = $post->translateOrNew($request->query('locale'));
        return view('media::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\Posts\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $post = $this->model::search(['id' => $id])->firstOrFail();
        $attributes = collect($request->input())->only($post->getFillable())->toArray();
        $attributes[$request->input('locale')] = $request->input();
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        if ($post->status == 'trash' && ! auth()->user()->can('backend media trash')) { return redirect()->route('backend.media.index'); }
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        if ($file = $request->file('qqfile')) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            $attributes['author_id'] = auth()->user()->id;
            $attributes['mime_type'] = $file->getMimeType();
            foreach (config('app.languages') as $languageCode => $languageName) {
                $attributes[$languageCode] = ['title' => $filename];
            }

            $medium = Media::create($attributes);
            $originalPath = 'media/original/'.$medium->id.'/'.$medium->name.'.'.$extension;
            $thumbnailPath = 'media/thumbnail/'.$medium->id.'/'.$medium->name.'.'.$extension;
            $file->storeAs('', $originalPath);

            $medium->setAttachedFile($originalPath);
            $thumbnailPath = $medium->setAttachedFileThumbnail($originalPath, $thumbnailPath);

            Postmetas::create(['post_id' => $medium->id, 'key' => 'attached_file', 'value' => $originalPath]);
            Postmetas::create(['post_id' => $medium->id, 'key' => 'attached_file_thumbnail', 'value' => $thumbnailPath]);
            Postmetas::create(['post_id' => $medium->id, 'key' => 'attachment_metadata', 'value' => json_encode(['extension' => $extension, 'size' => $file->getClientSize()])]);
        }

        return response()->json(['success' => true, 'thumbnailUrl' => \Storage::url($thumbnailPath)]);
    }
}
