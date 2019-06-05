<?php

namespace App\Models\Gallery;

use App\Models\Traits\HasRelatedImages;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasRelatedImages;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_categories';


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
        return 'name';
    }


    // MODEL RELATIONSHIPS

    /**
     * Set up HasMany relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }


    // MODEL QUERY SCOPES

    /**
     * Scope a query to return sorted categories
     *
     * @param \Illuminate\Database\Eloquent\Builder $query [the query builder instance]
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySortOrder($query)
    {
        return $query->orderBy('sortorder');
    }
}
