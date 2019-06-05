<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Http\Controllers\Controller;

use App\Http\Requests\Gallery\CategoryStoreFormRequest;
use App\Http\Requests\Gallery\CategoryUpdateFormRequest;

use App\Models\Gallery\Category;

use App\Services\ResourceItemSorting;

use Illuminate\Http\Request;

class CategoryController extends Controller
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
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        // Note: Will be set to empty collection if no categories exist
        $categories = $category->BySortOrder()->get();

        /* Parameters passed to view:
           $categories as collection of Eloquent models
        */
        return view('secure.admin.gallery.category.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('secure.admin.gallery.category.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Gallery\CategoryStoreFormRequest $request  [the current request instance]
     * @param \App\Models\Gallery\Category                        $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreFormRequest $request, Category $category)
    {
        // Note: Will be set to +1 if no categories exist
        $sortorder = $category->BySortOrder()->get()->max('sortorder') + 1;

        $category->create(array_merge($request->validated(), ['sortorder' => $sortorder]));

        return redirect()->route('admin.gallery.category.index')->with('messageSuccess', 'Category Creation Successful!');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // Note: At this point, due to route model binding, the category model instance can't be null
        $images = $category->images->sortby('sortorder');

        /* Parameters passed to view:
           $category as Eloquent model
           $images as collection of Eloquent models
        */
        return view('secure.admin.gallery.category.show', compact('category', 'images'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        /* Parameters passed to view:
           $category as Eloquent model
        */
        return view('secure.admin.gallery.category.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Gallery\CategoryUpdateFormRequest $request  [the current request instance]
     * @param \App\Models\Gallery\Category                         $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateFormRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.gallery.category.index')->with('messageSuccess', 'Category Update Successful!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        /* Note: associated stored files will be deleted via an event listener implemented in the category model.  Also, associated related/child records will be deleted (via "on cascade" implementation) */
        $category->delete();

        return redirect()->back()->with('messageSuccess', 'Category Deletion Successful!');
    }


    /**
     * AJAX request - perform a sorting update on the resource
     *
     * @param \Illuminate\Http\Request          $request         [the current request instance]
     * @param \App\Services\ResourceItemSorting $categorySorting [the sorting object instance]
     * @param \App\Models\Gallery\Category      $category        [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSortUpdate(Request $request, ResourceItemSorting $categorySorting, Category $category)
    {
        $categories = $category->all();

        $categorySorting->sortUpdate($request, $categories);

        return response('Update Successful', 200);
    }
}
