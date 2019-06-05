<?php

namespace App\Models\Gallery;

use App\Models\Traits\HasImage;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasImage;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_images';


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    // MODEL METHODS

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'title';
    }


    /**
     * Get the file associated with this model
     *
     * @return array
     */
    public function getFile()
    {
        return [$this->name];
    }


    // MODEL RELATIONSHIPS

    /**
     * Set up BelongsTo relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }


    // MODEL QUERY SCOPES

    /**
     * Scope a query to return sorted images
     *
     * @param \Illuminate\Database\Eloquent\Builder $query [the query builder instance]
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySortOrder($query)
    {
        $query->orderBy('sortorder');
    }
}
