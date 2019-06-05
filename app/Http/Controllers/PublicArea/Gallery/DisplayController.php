<?php

namespace App\Http\Controllers\PublicArea\Gallery;

use App\Http\Controllers\Controller;

use App\Models\Gallery\Category;
use App\Models\Gallery\Image;

class DisplayController extends Controller
{
    /**
     * Display gallery of images
     *
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function display(Category $category)
    {
        $images = array();

        // Note: will be set to empty collection if no categories exist
        $categories = $category->BySortOrder()->get();

        // Categories exist?
        if ($categories->isNotEmpty()) {
            // Is category model new/injected?
            if (!$category->exists) {
                // Default category to first model in sorted categories collection
                $category = $categories->first();
            }

            /* Default display to sorted images as per the given category
               Note: will return empty collection if no images exist */
            $sortedImages = $category->images->sortby('sortorder');

            $counter = 0;
            foreach ($sortedImages as $image) {
                $images[$counter] = ['href' => '/storage/'.$image->name, 'title' => $image->title, 'description' => $image->description];

                $counter++;
            }
        }

        /* Parameters passed to view:
           $categories as collection of Eloquent models
           $images as multi-dimensional array
           $sortedImages as Eloquent collection of Image models
        */
        return view('public.gallery.display', compact('categories', 'images', 'sortedImages'));
    }


    /**
     * Display a single image (method required for JavaScript disabled case)
     *
     * @param App\Models\Gallery\Image $image [the image model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function imageDisplay(Image $image)
    {
        return view('public.gallery.image.display', compact('image'));
    }
}
