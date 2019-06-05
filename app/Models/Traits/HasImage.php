<?php

namespace App\Models\Traits;

trait HasImage
{
    /**
     * Register a deleting model event with the dispatcher with the defined callback for deleting the image file
     *
     * @return void
     */
    public static function bootHasImage()
    {
        // Delete associated page media (if existing)
        static::deleting(
            function ($model) {
                (resolve('App\Services\Media\MediaInterface'))->delete($model->getFile());
            }
        );
    }
}
