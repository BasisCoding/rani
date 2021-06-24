<?php namespace Ams\Asset\Models;

use Model;

/**
 * History Model
 */
class History extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_asset_histories';

    /**
     * @var array Fillable fields
     */
    public $timestamps = false;

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
        'acquisitioned_at',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne        = [];
    public $hasMany       = [];
    public $belongsTo     = [
        'asset' => [
            'Ams\Asset\Models\AssetItem',
            'key'      => 'item_id',
            'otherKey' => 'id'
        ],
        'status' => [
            'Ams\Asset\Models\Status',
            'key'      => 'status_id',
            'otherKey' => 'id'
        ],
        'room' => [
            'Ams\Location\Models\Room',
            'key'      => 'room_id',
            'otherKey' => 'id'
        ],
        'employee' => [
            'Ams\Employee\Models\Employee',
            'key'      => 'employee_id',
            'otherKey' => 'id'
        ],
        'partner' => [
            'Ams\Asset\Models\Partner',
            'key'      => 'id',
            'otherKey' => 'history_id'
        ],
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
}
