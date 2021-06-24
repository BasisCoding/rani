<?php namespace Ams\Report\Models;

use Model;

/**
 * Report Model
 */
class Report extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_report_reports';

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
    public $hasMany       = [];
    public $belongsTo     = [
        'asset' => [
            'Ams\Asset\Models\AssetItem',
            'key'      => 'item_id',
            'otherKey' => 'id'
        ],
        'user' => [
            'Ams\User\Models\User',
            'key'      => 'user_id',
            'otherKey' => 'id'
        ],
    ];
    public $belongsToMany = [];
    public $morphTo       = [];
    public $morphOne      = [];
    public $morphMany     = [];
    public $attachOne     = [];
    public $attachMany    = [
        'attachments' => ['System\Models\File']
    ];

    public function beforeCreate()
    {
        $generator       = new \Ams\Core\Classes\Generator;
        $this->parameter = $generator->make();
    }
}
