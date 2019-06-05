<?php

namespace App\Models\Traits;

trait HasMedia
{
    /**
     * Register a deleting model event with the dispatcher with the defined callback for deleting the media file
     *
     * @return void
     */
    public static function bootHasMedia()
    {
        // Delete associated page media (if existing)
        static::deleting(
            function ($model) {
                (resolve('App\Services\Media\MediaInterface'))->delete($model->getFile());
            }
        );
    }
}
