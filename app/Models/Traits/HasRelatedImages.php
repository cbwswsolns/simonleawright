<?php

namespace App\Models\Traits;

trait HasRelatedImages
{
    /**
     * Register a deleting model event with the dispatcher with the defined callback for deleting related image files
     *
     * @return void
     */
    public static function bootHasRelatedImages()
    {
        // Delete associated images if they exist.
        static::deleting(
            function ($model) {
                $images = $model->images()->get();

                /* Non-empty collection of images? */
                if ($images->isNotEmpty()) {
                    // Fetch all image paths/filenames to an array
                    $imagesToDelete = array_merge(
                        $images->pluck('name')->toArray()
                    );

                    (resolve('App\Services\Media\MediaInterface'))->delete($imagesToDelete);
                }
            }
        );
    }
}
