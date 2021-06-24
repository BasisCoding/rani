<?php namespace Ams\Asset\Models;

use Model;

/**
 * Category Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Nullable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_asset_categories';

    /**
     * @var array Guarded fields
     */
    protected $nullable = ['name'];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['parameter'];

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
        'childs' => [
            'Ams\Asset\Models\Category',
            'key'      => 'parent_id',
            'otherKey' => 'id'
        ]
    ];
    public $belongsTo     = [
        'parent' => [
            'Ams\Asset\Models\Category',
            'key'      => 'parent_id',
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

    public function childOrders()
    {
        return \Ams\Asset\Models\Category::whereParentId($this->id)->orderBy('name')->get();
    }
}
