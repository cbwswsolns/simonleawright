<?php

namespace App\Http\Controllers\PublicArea\HomePage;

use App\Http\Controllers\Controller;

use App\Models\HomePage\Page;

class PageDisplayController extends Controller
{
    /**
     * Display the home page
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function display(Page $page)
    {
        $page = $page->first();

        /* Parameters passed to view:
           $page as Eloquent model
        */
        return view('public.homepage.display', compact('page'));
    }
}
