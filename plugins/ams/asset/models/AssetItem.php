<?php namespace Ams\Asset\Models;

use Carbon\Carbon;
use Model;

/**
 * Asset Model
 */
class AssetItem extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_asset_asset_items';

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
        'guaranteed_at',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne        = [];
    public $hasMany       = [
        'histories' => [
            'Ams\Asset\Models\History',
            'key'      => 'item_id',
            'otherKey' => 'id'
        ]
    ];
    public $belongsTo     = [
        'parent' => [
            'Ams\Asset\Models\Asset',
            'key'      => 'asset_id',
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
        ]
    ];
    public $belongsToMany = [];
    public $morphTo       = [];
    public $morphOne      = [];
    public $morphMany     = [];
    public $attachOne     = [
        'qrcode'     => ['System\Models\File'],
        'lable'      => ['System\Models\File'],
        'view_front' => ['System\Models\File'],
        'view_back'  => ['System\Models\File'],
        'view_left'  => ['System\Models\File'],
        'view_right' => ['System\Models\File'],
    ];
    public $attachMany    = [];

    public function beforeCreate()
    {
        $generator       = new \Ams\Core\Classes\Generator;
        $category        = \Ams\Asset\Models\Category::whereId(post('category_id'))->first();
        $dateY           = Carbon::parse($this->acquisitioned_at)->format('Y');
        $this->code      = $dateY.'-'.$category->parent->code.'-'.$generator->code();
        $generator       = new \Ams\Core\Classes\Generator;
        $this->parameter = $generator->make();
    }

    public function historyLast()
    {
        return \Ams\Asset\Models\History::whereItemId($this->id)->orderBy('id', 'desc')->first();
    }

    public function reoderHistory()
    {
        return \Ams\Asset\Models\History::whereItemId($this->id)->orderBy('id', 'desc')->get();
    }
}
