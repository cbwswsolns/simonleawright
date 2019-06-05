<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['secure.admin.dashboard'],
            'App\Http\ViewComposers\HomePage\PageComposer'
        );


        View::composer(
            ['public.layouts.nav.top-menu-right',
             'public.layouts.nav.top-menu-no-js',
             'secure.partials.admin.nav.top-menu-no-js',
             'secure.partials.admin.nav.top-menu-left',
             'secure.partials.admin.nav.category-sub-menu',
             'secure.partials.admin.nav.category-sub-menu-no-js',
             'secure.admin.gallery.image.edit',
             'secure.admin.gallery.image.create'
            ],
            'App\Http\ViewComposers\Gallery\CategoryComposer'
        );
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
