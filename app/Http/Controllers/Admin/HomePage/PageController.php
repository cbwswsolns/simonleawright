<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;

use App\Http\Requests\HomePage\PageFormRequest;

use App\Models\HomePage\Page;

use App\Services\HomePage\PageService;

class PageController extends Controller
{
    /**
     * Page service instance
     *
     * @var \App\Services\HomePage\PageService;
     */
    protected $pageService;


    /**
     * Create a new controller instance.
     *
     * @param \App\Services\HomePage\PageService $pageService [the page service instance]
     *
     * @return void
     */
    public function __construct(PageService $pageService)
    {
        $this->middleware('auth:admin');

        $this->pageService = $pageService;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('secure.admin.homepage.page.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\HomePage\PageFormRequest $request [the current request instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageFormRequest $request)
    {
        $this->pageService->store(array_merge($request->validated(), ['media_ids' => $request->input('media_ids')]));

        return redirect()->route('admin.dashboard');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        /* Parameters passed to view:
           $page as Eloquent models
        */
        return view('secure.admin.homepage.page.edit', compact('page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\HomePage\PageFormRequest $request [the current request instance]
     * @param \App\Models\HomePage\Page                   $page    [the page model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageFormRequest $request, Page $page)
    {
        $this->pageService->update(array_merge($request->validated(), ['media_ids' => $request->input('media_ids')]), $page);

        return redirect()->route('admin.dashboard');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        // Note: associated media will be deleted from storage via a periodically scheduled CRON job
        $this->pageService->delete($page);

        return redirect()->route('admin.dashboard');
    }
}
