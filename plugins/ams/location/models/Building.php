<?php namespace Ams\Location\Models;

use Model;

/**
 * Building Model
 */
class Building extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_location_buildings';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne        = [];
    public $hasMany       = [
        'rooms' => [
            'Ams\Location\Models\Room',
            'key'      => 'building_id',
            'otherKey' => 'id'
        ]
    ];
    public $belongsTo     = [
        'office' => [
            'Ams\Location\Models\Office',
            'key'      => 'office_id',
            'otherKey' => 'id'
        ]
    ];
    public $belongsToMany = [];
    public $morphTo       = [];
    public $morphOne      = [];
    public $morphMany     = [];
    public $attachOne     = [];
    public $attachMany    = [];

    public function beforeCreate()
    {
        $generator       = new \Ams\Core\Classes\Generator;
        $this->parameter = $generator->make();
    }

    public function beforeSave()
    {
        $this->slug = str_slug($this->name);
    }

    public function roomOrder()
    {
        return \Ams\Location\Models\Room::whereBuildingId($this->id)->orderBy('name')->get();
    }
}
