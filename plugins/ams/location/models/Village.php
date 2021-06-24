<?php namespace Ams\Location\Models;

use Model;

/**
 * Village Model
 */
class Village extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_location_villages';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
