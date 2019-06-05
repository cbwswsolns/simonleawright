<?php

namespace App\Models;

use App\Models\HomePage\Page;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /* Note: as table name is "admins", there is no need to specify a table property for this model as "admins" is the default name */

    /**
     * Admin guard
     *
     * @var string
     */
    protected $guard = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    // MODEL METHODS

    /**
     * Publish the page
     *
     * @param \App\Models\HomePage\Page $page [the page model instance]
     *
     * @return \App\Models\HomePage\Page
     */
    public function publish(Page $page)
    {
        $this->pages()->save($page);

        return $page;
    }


    // MODEL RELATIONSHIPS

    /**
     * Set up HasMany relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
