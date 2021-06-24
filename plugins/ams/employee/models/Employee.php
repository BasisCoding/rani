<?php namespace Ams\Employee\Models;

use Model;

/**
 * Employee Model
 */
class Employee extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Nullable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ams_employee_employees';


    /**
     * @var string The database table used by the model.
     */
    protected $nullable = ['department_id', 'team_id', 'unit_id'];

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
        'department' => [
            'Ams\Employee\Models\Department',
            'key'      => 'department_id',
            'otherKey' => 'id'
        ],
        'team' => [
            'Ams\Employee\Models\Team',
            'key'      => 'team_id',
            'otherKey' => 'id'
        ],
        'unit' => [
            'Ams\Employee\Models\Unit',
            'key'      => 'unit_id',
            'otherKey' => 'id'
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
