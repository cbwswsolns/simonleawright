<?php

namespace App\Models\HomePage;

use App\Models\Traits\HasMedia;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'homepage_media';


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    // MODEL METHODS

    /**
     * Get the file associated with this model
     *
     * @return array
     */
    public function getFile()
    {
        return [$this->filename];
    }


    // MODEL RELATIONSHIPS

    /**
     * Set up BelongsToMany relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'homepage_media_homepage_page');
    }
}
