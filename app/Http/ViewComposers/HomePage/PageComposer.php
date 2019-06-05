<?php

namespace App\Http\ViewComposers\HomePage;

use App\Models\HomePage\Page;

use Illuminate\View\View;

class PageComposer
{
    /**
     * The page model instance
     *
     * @var \App\Models\HomePage\Page
     */
    protected $page;


    /**
     * Create a new composer instance
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        // Dependencies automatically resolved by service container...
        $this->page = $page;
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
        // Note: page will be set to null if no page exists
        $view->with('page', $this->page->first());
    }
}
