<?php

namespace App\Http\Controllers\PublicArea\AboutPage;

use App\Http\Controllers\Controller;

class PageDisplayController extends Controller
{
    /**
     * Display the about page
     *
     * @return \Illuminate\Http\Response
     */
    public function display()
    {
        return view('public.aboutpage.display');
    }
}
