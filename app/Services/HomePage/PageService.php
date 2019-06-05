<?php

namespace App\Services\HomePage;

use Purifier;

use App\Models\HomePage\Media;
use App\Models\HomePage\Page;

use Illuminate\Support\Str;

class PageService
{
    /**
     * Page model instance
     *
     * @var \App\Models\HomePage\Page
     */
    protected $page;


    /**
     * Create a new service instance.
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }


    /**
     * Store home page method
     *
     * @param array $data [the data to use to create a new page]
     *
     * @return \App\Models\HomePage\Page
     */
    public function store(array $data)
    {
        $body = Purifier::clean($data['body'], array('Attr.AllowedFrameTargets' => ['_target' => true]));

        $page = auth()->user()->publish(
            new Page(['body' => $body])
        );

        if ($page) {
            $this->attachMediaToPage($page, explode(',', rtrim($data['media_ids'], ",")));
        }

        session()->flash('status', 'Page has now been created!');

        return $page;
    }


    /**
     * Update home page method
     *
     * @param array                     $data [the data to use to update the given page]
     * @param \App\Models\HomePage\Page $page [the page model instance to update]
     *
     * @return \App\Models\HomePage\Page
     */
    public function update(array $data, Page $page)
    {
        $body = Purifier::clean($data['body'], array('Attr.AllowedFrameTargets' => ['_target' => true]));

        if ($page) {
            $page->update(['body' => $body]);

            $this->attachMediaToPage($page, explode(',', rtrim($data['media_ids'], ",")));
        }

        session()->flash('status', 'Page has now been updated!');

        return $page;
    }


    /**
     * Delete method
     *
     * @param \App\Models\HomePage\Page $page [the page model to delete]
     *
     * @return void
     */
    public function delete(Page $page)
    {
        /* Associated stored files will be deleted via a page model "deleting" event listener.
           Associated related/child records will be deleted (via "on cascade" implementation) */
        $page->delete();

        session()->flash('status', 'Page deleted!');
    }


    /**
     * Attach Media to Page method
     *
     * @param \App\Models\HomePage\Page $page     [the page model instance]
     * @param array                     $mediaIds [ids of the media to attach to the page]
     *
     * @return void
     */
    protected function attachMediaToPage($page, $mediaIds)
    {
        if ($mediaIds) {
            // Extract all media records according to the filtered set of ids
            $mediaItems = (new Media)->findMany($mediaIds);

            // Remove all media records and associated storage not in the final WYSIWYG html page
            $mediaIds = [];
            foreach ($mediaItems as $mediaItem) {
                if (!Str::contains($page->body, $mediaItem->filename)) {
                    $mediaItem->delete();
                    (resolve('App\Services\Media\MediaInterface'))->delete($mediaItem->filename);

                    continue;
                }
                
                $mediaIds[] = $mediaItem->id;
            };

            $page->media()->sync($mediaIds);
        }
    }
}
