<?php

namespace App\Http\ViewComposers\Gallery;

use App\Models\Gallery\Category;

use Illuminate\View\View;

class CategoryComposer
{
    /**
     * The category model instance
     *
     * @var \App\Models\Gallery\Category
     */
    protected $category;


    /**
     * Create a new composer instance
     *
     * @param \App\Models\Gallery\Category $category [the category model instance]
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        // Dependencies automatically resolved by service container...
        $this->category = $category;
    }


    /**
     * Bind data to the view.
     *
     * @param View $view [the view instance]
     *
     * @return void
     */
    public function compose(View $view)
    {
        // Note: categories will be set to empty collection if no categories exist
        $view->with('categories', $this->category->BySortOrder()->get());
    }
}
