<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;

use App\Http\Requests\HomePage\PageMediaStoreFormRequest;

use App\Models\HomePage\Media;

class PageMediaController extends Controller
{
    /**
     * AJAX request - page media upload
     *
     * @param \App\Http\Requests\HomePage\PageMediaStoreFormRequest $request [the current request instance]
     * @param \App\Models\HomePage\Media                            $media   [the media model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(PageMediaStoreFormRequest $request, Media $media)
    {
        $uploadedFile = $request->validated()['file'];

        $path = (resolve('App\Services\Media\MediaInterface'))->store($uploadedFile, 'media');

        $media = $media->create(['filename' => $path, 'name' => $uploadedFile->getClientOriginalName()]);

        return \Response::json(['location' => '/storage/'.$path, 'id' => $media->id]);
    }
}
