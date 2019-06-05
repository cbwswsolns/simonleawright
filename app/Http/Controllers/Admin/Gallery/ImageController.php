<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;

use App\Http\Requests\Gallery\ImageStoreFormRequest;
use App\Http\Requests\Gallery\ImageUpdateFormRequest;

use App\Models\Gallery\Image;

use App\Services\ResourceItemSorting;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Gallery\Image $image [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Image $image)
    {
        // Note: Will be set to empty collection if no images exist
        $images = $image->BySortOrder()->get();

        /* Parameters passed to view:
           $images as collection of Eloquent models
        */
        return view('secure.admin.gallery.image.index', compact('images'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('secure.admin.gallery.image.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Gallery\ImageStoreFormRequest $request [the current request instance]
     * @param \App\Models\Gallery\Image                        $image   [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ImageStoreFormRequest $request, Image $image)
    {
        // Note: Will be set to +1 if no images exist
        $sortorder = $image->BySortOrder()->get()->max('sortorder') + 1;

        if ($request->has('image')) {
            $uploadedFile = $request->validated()['image'];

            $path = (resolve('App\Services\Media\MediaInterface'))->store($uploadedFile, 'media');

            $image->create(
                ['title' => $request->validated()['title'],
                 'name' => $path,
                 'category_id' => $request->validated()['category_id'],
                 'description' => $request->validated()['description'],
                 'sortorder' => $sortorder
                ]
            );
        }

        // Return to image listing
        return redirect()->route('admin.gallery.image.index')->with('messageSuccess', 'Image Creation Successful!');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Gallery\Image $image [the image model instance]
     *
     * @return Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        /* Parameters passed to view:
           $image as Eloquent model
        */
        return view('secure.admin.gallery.image.show', compact('image'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gallery\Image $image [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        /* Parameters passed to view:
           $image as Eloquent model
        */
        return view('secure.admin.gallery.image.edit', compact('image'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Gallery\ImageUpdateFormRequest $request [the current request instance]
     * @param \App\Models\Gallery\Image                         $image   [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ImageUpdateFormRequest $request, Image $image)
    {
        $image->update(
            ['title' => $request->validated()['title'],
             'category_id' => $request->validated()['category_id'],
             'description' => $request->validated()['description']
            ]
        );

        if ($request->has('image')) {
            $uploadedFile = $request->validated()['image'];

            $mediaService = resolve('App\Services\Media\MediaInterface');

            $path = $mediaService->store($uploadedFile, 'media');

            // Can now delete previous/existing file from storage
            $mediaService->delete($image->name);

            // Update record with new file name
            $image->update(['name' => $path]);
        }

        // Return to image listing
        return redirect()->route('admin.gallery.image.index')->with('messageSuccess', 'Image Update Successful!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gallery\Image $image [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        // Delete file from storage
        (resolve('App\Services\Media\MediaInterface'))->delete($image->name);

        // Delete associated image record
        $image->delete();

        return redirect()->back()->with('messageSuccess', 'Image Deletion Successful!');
    }


    /**
     * AJAX request - perform a sorting update on the resource
     *
     * @param \Illuminate\Http\Request          $request      [the current request instance]
     * @param \App\Services\ResourceItemSorting $imageSorting [the sorting object instance]
     * @param \App\Models\Gallery\Image         $image        [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSortUpdate(Request $request, ResourceItemSorting $imageSorting, Image $image)
    {
        $images = $image->all();

        $imageSorting->sortUpdate($request, $images);

        return response('Sort Update Successful', 200);
    }
}
